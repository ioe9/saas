<?php
class Mage_Core_Model_App
{
    const XML_PATH_INSTALL_DATE = 'global/install/date';

    const XML_PATH_SKIP_PROCESS_MODULES_UPDATES = 'global/skip_process_modules_updates';

    /**
     * if this node set to true, we will ignore Developer Mode for applying updates
     */
    const XML_PATH_IGNORE_DEV_MODE = 'global/skip_process_modules_updates_ignore_dev_mode';

    const DEFAULT_ERROR_HANDLER = 'mageCoreErrorHandler';

    /**
     * Cache tag for all cache data exclude config cache
     *
     */
    const CACHE_TAG = 'MAGE';

    /**
     * Application loaded areas array
     *
     * @var array
     */
    protected $_areas = array();

    /**
     * Application design package object
     *
     * @var Mage_Core_Model_Design_Package
     */
    protected $_design;

    /**
     * Application layout object
     *
     * @var Mage_Core_Model_Layout
     */
    protected $_layout;

    /**
     * Application configuration object
     *
     * @var Mage_Core_Model_Config
     */
    protected $_config;

    /**
     * Application front controller
     *
     * @var Mage_Core_Controller_Varien_Front
     */
    protected $_frontController;

    /**
     * Cache object
     *
     * @var Zend_Cache_Core
     */
    protected $_cache;

    /**
     * Request object
     *
     * @var Zend_Controller_Request_Http
     */
    protected $_request;

    /**
     * Response object
     *
     * @var Zend_Controller_Response_Http
     */
    protected $_response;

	protected $_translator;
    /**
     * Events cache
     *
     * @var array
     */
    protected $_events = array();

    /**
     * Update process run flag
     *
     * @var bool
     */
    protected $_updateMode = false;

    /**
     * Use session in URL flag
     *
     * @see Mage_Core_Model_Url
     * @var bool
     */
    protected $_useSessionInUrl = true;

    /**
     * Use session var instead of SID for session in URL
     *
     * @var bool
     */
    protected $_useSessionVar = false;

    /**
     * Cache locked flag
     *
     * @var null|bool
     */
    protected $_isCacheLocked = null;

    /**
     * Flag for Mage installation status
     *
     * @var null|bool
     */
    protected $_isInstalled = null;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Initialize application without request processing
     *
     * @param  string|array $code
     * @param  string $type
     * @param  string|array $options
     * @return Mage_Core_Model_App
     */
    public function init($code, $type = null, $options = array())
    {
        $this->setErrorHandler(self::DEFAULT_ERROR_HANDLER);
        if (is_string($options)) {
            $options = array('etc_dir'=>$options);
        }

        Varien_Profiler::start('mage::app::init::config');
        $this->_config = Mage::getConfig();
        $this->_config->setOptions($options);
        $this->_initBaseConfig();
        $this->_initCache();
        $this->_config->init($options);
        Varien_Profiler::stop('mage::app::init::config');

        if ($this->_isInstalled === null) {
            $this->_isInstalled = Mage::isInstalled($options);
        }

        if ($this->_isInstalled) {
            $this->_initRequest();
        }
        return $this;
    }

    /**
     * Common logic for all run types
     *
     * @param  string|array $options
     * @return Mage_Core_Model_App
     */
    public function baseInit($options)
    {
        $this->setErrorHandler(self::DEFAULT_ERROR_HANDLER); //设置自定义错误处理函数
        $this->_config = Mage::getConfig();
        $this->_initBaseConfig(); //加载 app/etc 下的local.xml and config.xml 文件
        $cacheInitOptions = is_array($options) && array_key_exists('cache', $options) ? $options['cache'] : array();
        $this->_initCache($cacheInitOptions);

        return $this;
    }
    /**
     * Run application. Run process responsible for request processing and sending response.
     * List of supported parameters:
     *  scope_code - code of default scope (website/store_group/store code)
     *  scope_type - type of default scope (website/group/store)
     *  options    - configuration options
     *
     * @param  array $params application run parameters
     * @return Mage_Core_Model_App
     */
    public function run($params)
    {
        $options = isset($params['options']) ? $params['options'] : array();
        $this->baseInit($options);
        Mage::register('application_params', $params);
        if ($this->_cache->processRequest()) { //重要切入点
        	//全页缓存
            $this->getResponse()->sendResponse();
        } else {
            $this->_initModules();
            $this->loadAreaPart(Mage_Core_Model_App_Area::AREA_GLOBAL, Mage_Core_Model_App_Area::PART_EVENTS);
            if ($this->_config->isLocalConfigLoaded()) {
                $this->_initRequest();
				if (MAGE_UPDATE) {
					//Apply database data updates whenever needed
					Mage_Core_Model_Resource_Setup::applyAllDataUpdates();
				}
            }
			//Mage_Core_Controller_Varien_Front->init()->dispatch()
            $this->getFrontController()->dispatch();
        }
        
        return $this;
    }
    
    /***
     * 获取系统配置  TODO
     */
    public function getStoreConfig($path)
    {
    	$config = Mage::getConfig();

        $fullPath = $path;
        $data = $config->getNode($fullPath);
        
        //var_dump($data);
        if (!$data && !Mage::isInstalled()) {
            $data = $config->getNode('default/' . $path);
        }
        if (!$data) {
            return null;
        }
        return $this->_processConfigValue($fullPath, $path, $data);
    }
    protected function _processConfigValue($fullPath, $path, $node)
    {
        if ($node->hasChildren()) {
            $aValue = array();
            foreach ($node->children() as $k => $v) {
                $aValue[$k] = $this->_processConfigValue($fullPath . '/' . $k, $path . '/' . $k, $v);
            }
            $this->_configCache[$path] = $aValue;
            return $aValue;
        }

        $sValue = (string) $node;
        if (!empty($node['backend_model']) && !empty($sValue)) {
            $backend = Mage::getModel((string) $node['backend_model']);
            $backend->setPath($path)->setValue($sValue)->afterLoad();
            $sValue = $backend->getValue();
        }

        if (is_string($sValue) && strpos($sValue, '{{') !== false) {
            if (strpos($sValue, '{{unsecure_base_url}}') !== false) {
                $unsecureBaseUrl = $this->getStoreConfig(self::XML_PATH_UNSECURE_BASE_URL);
                $sValue = str_replace('{{unsecure_base_url}}', $unsecureBaseUrl, $sValue);
            } elseif (strpos($sValue, '{{secure_base_url}}') !== false) {
                $secureBaseUrl = $this->getStoreConfig(self::XML_PATH_SECURE_BASE_URL);
                $sValue = str_replace('{{secure_base_url}}', $secureBaseUrl, $sValue);
            } elseif (strpos($sValue, '{{base_url}}') !== false) {
                $sValue = Mage::getConfig()->substDistroServerVars($sValue);
            }
        }

        return $sValue;
    }

    /**
     * Initialize base system configuration (local.xml and config.xml files).
     * Base configuration provide ability initialize DB connection and cache backend
     *
     * @return Mage_Core_Model_App
     */
    protected function _initBaseConfig()
    {
        Varien_Profiler::start('mage::app::init::system_config');
        $this->_config->loadBase();
        Varien_Profiler::stop('mage::app::init::system_config');
        return $this;
    }

    /**
     * Initialize application cache instance
     *
     * @param array $cacheInitOptions
     * @return Mage_Core_Model_App
     */
    protected function _initCache(array $cacheInitOptions = array())
    {
        $this->_isCacheLocked = true;
        $options = $this->_config->getNode('global/cache');
        //echo "<xmp>";var_dump($options);die();
        if ($options) {
            $options = $options->asArray();
        } else {
            $options = array();
        }
        $options = array_merge($options, $cacheInitOptions);
        $this->_cache = Mage::getModel('core/cache', $options);
        $this->_isCacheLocked = false;
        return $this;
    }

    /**
     * Initialize active modules configuration and data
     *
     * @return Mage_Core_Model_App
     */
    protected function _initModules()
    {
        if (!$this->_config->loadModulesCache()) {
        	
            $this->_config->loadModules();
            
            //MAGE_UPDATE 更新模式下
            if (MAGE_UPDATE && $this->_config->isLocalConfigLoaded() && !$this->_shouldSkipProcessModulesUpdates()) {
                
                Varien_Profiler::start('mage::app::init::apply_db_schema_updates');
                //更新脚本 Apply database updates whenever needed
                Mage_Core_Model_Resource_Setup::applyAllUpdates();
                Varien_Profiler::stop('mage::app::init::apply_db_schema_updates');
            }
            //加载core_config_data表
            $this->_config->loadDb();
            //var_dump(Mage::app()->getConfig());die();
            $this->_config->saveCache();
        }
        return $this;
    }

    /**
     * Check whether modules updates processing should be skipped
     *
     * @return bool
     */
    protected function _shouldSkipProcessModulesUpdates()
    {
        if (!Mage::isInstalled()) {
            return false;
        }

        $ignoreDevelopmentMode = (bool)(string)$this->_config->getNode(self::XML_PATH_IGNORE_DEV_MODE);
        if (Mage::getIsDeveloperMode() && !$ignoreDevelopmentMode) {
            return false;
        }

        return (bool)(string)$this->_config->getNode(self::XML_PATH_SKIP_PROCESS_MODULES_UPDATES);
    }

    /**
     * Init request object
     *
     * @return Mage_Core_Model_App
     */
    protected function _initRequest()
    {
    	//Mage_Core_Controller_Request_Http->setPathInfo
        $this->getRequest()->setPathInfo();
        return $this;
    }

    /**
     * Retrieve cookie object
     *
     * @return Mage_Core_Model_Cookie
     */
    public function getCookie()
    {
        return Mage::getSingleton('core/cookie');
    }


    /**
     * Initialize application front controller
     *
     * @return Mage_Core_Model_App
     */
    protected function _initFrontController()
    {
        $this->_frontController = new Mage_Core_Controller_Varien_Front();
        Mage::register('controller', $this->_frontController);
        Varien_Profiler::start('mage::app::init_front_controller');
        $this->_frontController->init();
        Varien_Profiler::stop('mage::app::init_front_controller');
        return $this;
    }

    /**
     * Redeclare custom error handler
     *
     * @param   string $handler
     * @return  Mage_Core_Model_App
     */
    public function setErrorHandler($handler)
    {
        set_error_handler($handler);
        return $this;
    }

    /**
     * Loading application area
     *
     * @param   string $code
     * @return  Mage_Core_Model_App
     */
    public function loadArea($code)
    {
        $this->getArea($code)->load();
        return $this;
    }

    /**
     * Loding part of area data
     *
     * @param   string $area
     * @param   string $part
     * @return  Mage_Core_Model_App
     */
    public function loadAreaPart($area, $part)
    {
        $this->getArea($area)->load($part);
        return $this;
    }

    /**
     * Retrieve application area
     *
     * @param   string $code
     * @return  Mage_Core_Model_App_Area
     */
    public function getArea($code)
    {
        if (!isset($this->_areas[$code])) {
            $this->_areas[$code] = new Mage_Core_Model_App_Area($code, $this);
        }
        return $this->_areas[$code];
    }

    /**
     * Retrieve application locale object
     *
     * @return Mage_Core_Model_Locale
     */
    public function getLocale()
    {
        if (!$this->_locale) {
            $this->_locale = Mage::getSingleton('core/locale');
        }
        return $this->_locale;
    }

    /**
     * Retrive layout object
     *
     * @return Mage_Core_Model_Layout
     */
    public function getLayout()
    {
        if (!$this->_layout) {
            if ($this->getFrontController()->getAction()) {
                $this->_layout = $this->getFrontController()->getAction()->getLayout();
            } else {
                $this->_layout = Mage::getSingleton('core/layout');
            }
        }
        return $this->_layout;
    }

    /**
     * Retrieve translate object
     *
     * @return Mage_Core_Model_Translate
     */
    public function getTranslator()
    {
        if (!$this->_translator) {
            $this->_translator = Mage::getSingleton('core/translate');
        }
        return $this->_translator;
    }

    /**
     * Retrieve helper object
     *
     * @param string $name
     * @return Mage_Core_Helper_Abstract
     */
    public function getHelper($name)
    {
        return Mage::helper($name);
    }

    /**
     * Retrieve application base currency code
     *
     * @return string
     */
    public function getBaseCurrencyCode()
    {
        return (string) Mage::app()->getConfig()
            ->getNode('default/' . Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE);
    }

    /**
     * Retrieve configuration object
     *
     * @return Mage_Core_Model_Config
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * Retrieve front controller object
     *
     * @return Mage_Core_Controller_Varien_Front
     */
    public function getFrontController()
    {
        if (!$this->_frontController) {
            $this->_initFrontController();
        }

        return $this->_frontController;
    }

    /**
     * Get core cache model
     *
     * @return Mage_Core_Model_Cache
     */
    public function getCacheInstance()
    {
        if (!$this->_cache) {
            $this->_initCache();
        }
        return $this->_cache;
    }

    /**
     * Retrieve cache object
     *
     * @return Zend_Cache_Core
     */
    public function getCache()
    {
        if (!$this->_cache) {
            $this->_initCache();
        }
        return $this->_cache->getFrontend();
    }

    /**
     * Loading cache data
     *
     * @param   string $id
     * @return  mixed
     */
    public function loadCache($id)
    {
        return $this->_cache->load($id);
    }

    /**
     * Saving cache data
     *
     * @param   mixed $data
     * @param   string $id
     * @param   array $tags
     * @return  Mage_Core_Model_App
     */
    public function saveCache($data, $id, $tags=array(), $lifeTime=false)
    {
        $this->_cache->save($data, $id, $tags, $lifeTime);
        return $this;
    }

    /**
     * Remove cache
     *
     * @param   string $id
     * @return  Mage_Core_Model_App
     */
    public function removeCache($id)
    {
        $this->_cache->remove($id);
        return $this;
    }

    /**
     * Cleaning cache
     *
     * @param   array $tags
     * @return  Mage_Core_Model_App
     */
    public function cleanCache($tags=array())
    {
        $this->_cache->clean($tags);
        Mage::dispatchEvent('application_clean_cache', array('tags' => $tags));
        return $this;
    }

    /**
    * Check whether to use cache for specific component
    *
    * @return boolean
    */
    public function useCache($type=null)
    {
        return $this->_cache->canUse($type);

    }

    /**
     * Save cache usage settings
     *
     * @param array $data
     * @return Mage_Core_Model_App
     */
    public function saveUseCache($data)
    {
        $this->_cache->saveOptions($data);
        return $this;
    }

    /**
     * Deletes all session files
     *
     */
    public function cleanAllSessions()
    {
        if (session_module_name()=='files') {
            $dir = session_save_path();
            mageDelTree($dir);
        }
        return $this;
    }

    /**
     * Retrieve request object
     *
     * @return Mage_Core_Controller_Request_Http
     */
    public function getRequest()
    {
        if (empty($this->_request)) {
            $this->_request = new Mage_Core_Controller_Request_Http();
        }
        return $this->_request;
    }

    /**
     * Request setter
     *
     * @param Mage_Core_Controller_Request_Http $request
     * @return Mage_Core_Model_App
     */
    public function setRequest(Mage_Core_Controller_Request_Http $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * Retrieve response object
     *
     * @return Zend_Controller_Response_Http
     */
    public function getResponse()
    {
        if (empty($this->_response)) {
            $this->_response = new Mage_Core_Controller_Response_Http();
            $this->_response->headersSentThrowsException = Mage::$headersSentThrowsException;
            $this->_response->setHeader("Content-Type", "text/html; charset=UTF-8");
        }
        return $this->_response;
    }

    /**
     * Response setter
     *
     * @param Mage_Core_Controller_Response_Http $response
     * @return Mage_Core_Model_App
     */
    public function setResponse(Mage_Core_Controller_Response_Http $response)
    {
        $this->_response = $response;
        return $this;
    }

    public function addEventArea($area)
    {
        if (!isset($this->_events[$area])) {
            $this->_events[$area] = array();
        }
        return $this;
    }

    public function dispatchEvent($eventName, $args)
    {
        foreach ($this->_events as $area=>$events) {
            if (!isset($events[$eventName])) {
                $eventConfig = $this->getConfig()->getEventConfig($area, $eventName);
                if (!$eventConfig) {
                    $this->_events[$area][$eventName] = false;
                    continue;
                }
                $observers = array();
                foreach ($eventConfig->observers->children() as $obsName=>$obsConfig) {
                    $observers[$obsName] = array(
                        'type'  => (string)$obsConfig->type,
                        'model' => $obsConfig->class ? (string)$obsConfig->class : $obsConfig->getClassName(),
                        'method'=> (string)$obsConfig->method,
                        'args'  => (array)$obsConfig->args,
                    );
                }
                $events[$eventName]['observers'] = $observers;
                $this->_events[$area][$eventName]['observers'] = $observers;
            }
            if (false===$events[$eventName]) {
                continue;
            } else {
                $event = new Varien_Event($args);
                $event->setName($eventName);
                $observer = new Varien_Event_Observer();
            }

            foreach ($events[$eventName]['observers'] as $obsName=>$obs) {
                $observer->setData(array('event'=>$event));
                Varien_Profiler::start('OBSERVER: '.$obsName);
                switch ($obs['type']) {
                    case 'disabled':
                        break;
                    case 'object':
                    case 'model':
                        $method = $obs['method'];
                        $observer->addData($args);
                        $object = Mage::getModel($obs['model']);
                        $this->_callObserverMethod($object, $method, $observer);
                        break;
                    default:
                        $method = $obs['method'];
                        $observer->addData($args);
                        $object = Mage::getSingleton($obs['model']);
                        $this->_callObserverMethod($object, $method, $observer);
                        break;
                }
                Varien_Profiler::stop('OBSERVER: '.$obsName);
            }
        }
        return $this;
    }

    /**
     * Performs non-existent observer method calls protection
     *
     * @param object $object
     * @param string $method
     * @param Varien_Event_Observer $observer
     * @return Mage_Core_Model_App
     * @throws Mage_Core_Exception
     */
    protected function _callObserverMethod($object, $method, $observer)
    {
        if (method_exists($object, $method)) {
            $object->$method($observer);
        } elseif (Mage::getIsDeveloperMode()) {
            Mage::throwException('Method "'.$method.'" is not defined in "'.get_class($object).'"');
        }
        return $this;
    }

    public function setUpdateMode($value)
    {
        $this->_updateMode = $value;
    }

    public function getUpdateMode()
    {
        return $this->_updateMode;
    }

    public function throwStoreException()
    {
    	//die("throwStoreException");
        throw new Mage_Core_Exception('');
    }

    /**
     * Set use session var instead of SID for URL
     *
     * @param bool $var
     * @return Mage_Core_Model_App
     */
    public function setUseSessionVar($var)
    {
        $this->_useSessionVar = (bool)$var;
        return $this;
    }

    /**
     * Retrieve use flag session var instead of SID for URL
     *
     * @return bool
     */
    public function getUseSessionVar()
    {
        return $this->_useSessionVar;
    }


    /**
     * Set Use session in URL flag
     *
     * @param bool $flag
     * @return Mage_Core_Model_App
     */
    public function setUseSessionInUrl($flag = true)
    {
        $this->_useSessionInUrl = (bool)$flag;
        return $this;
    }

    /**
     * Retrieve use session in URL flag
     *
     * @return bool
     */
    public function getUseSessionInUrl()
    {
        return $this->_useSessionInUrl;
    }
    /**
     * Prepare array of store groups
     * can be filtered to contain default store group or not by $withDefault flag
     * depending on flag $codeKey array keys can be group id or group code
     *
     * @param bool $withDefault
     * @param bool $codeKey
     * @return array
     */
    public function getGroups($withDefault = false, $codeKey = false)
    {
        $groups = array();
        if (is_array($this->_groups)) {
            foreach ($this->_groups as $group) {
                if (!$withDefault && $group->getId() == 0) {
                    continue;
                }
                if ($codeKey) {
                    $groups[$group->getCode()] = $group;
                }
                else {
                    $groups[$group->getId()] = $group;
                }
            }
        }

        return $groups;
    }

    /**
     * Retrieve application installation flag
     *
     * @deprecated since 1.2
     * @return bool
     */
    public function isInstalled()
    {
        return Mage::isInstalled();
    }

    /**
     * Generate cache tags from cache id
     *
     * @deprecated after 1.4.0.0-alpha3, functionality implemented in Mage_Core_Model_Cache
     * @param   string $id
     * @param   array $tags
     * @return  array
     */
    protected function _getCacheTags($tags=array())
    {
        foreach ($tags as $index=>$value) {
            $tags[$index] = $this->_getCacheId($value);
        }
        return $tags;
    }

    /**
     * Get file name with cache configuration settings
     *
     * @deprecated after 1.4.0.0-alpha3, functionality implemented in Mage_Core_Model_Cache
     * @return string
     */
    public function getUseCacheFilename()
    {
        return $this->_config->getOptions()->getEtcDir().DS.'use_cache.ser';
    }

    /**
     * Generate cache id with application specific data
     *
     * @deprecated after 1.4.0.0-alpha3, functionality implemented in Mage_Core_Model_Cache
     * @param   string $id
     * @return  string
     */
    protected function _getCacheId($id=null)
    {
        if ($id) {
            $id = $this->prepareCacheId($id);
        }
        return $id;
    }

    /**
     * Prepare identifier which can be used as cache id or cache tag
     *
     * @deprecated after 1.4.0.0-alpha3, functionality implemented in Mage_Core_Model_Cache
     * @param   string $id
     * @return  string
     */
    public function prepareCacheId($id)
    {
        $id = strtoupper($id);
        $id = preg_replace('/([^a-zA-Z0-9_]{1,1})/', '_', $id);
        return $id;
    }

    /**
     * Get is cache locked
     *
     * @return bool
     */
    public function getIsCacheLocked()
    {
        return (bool)$this->_isCacheLocked;
    }

    
    public function getStore() {
    	return Mage::getSingleton('core/store');
    }
}

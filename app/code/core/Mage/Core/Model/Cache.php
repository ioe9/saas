<?php
class Mage_Core_Model_Cache
{
    /**
     * Cache settings
     */
    const DEFAULT_LIFETIME  = 7200;
    const OPTIONS_CACHE_ID  = 'core_cache_options';
    const INVALIDATED_TYPES = 'core_cache_invalidate';
    const XML_PATH_TYPES    = 'global/cache/types';

    /**
     * Id prefix
     *
     * @var string
     */
    protected $_idPrefix    = '';

    /**
     * Cache frontend API
     *
     * @var Varien_Cache_Core
     */
    protected $_frontend;

    /**
     * Shared memory backend models list (required TwoLevels backend model)
     *
     * @var array
     */
    protected $_shmBackends = array(
        'apc', 'memcached', 'xcache',
    );

    /**
     * Default cache backend type
     *
     * @var string
     */
    protected $_defaultBackend = 'File';

    /**
     * Default options for default backend
     *
     * @var array
     */
    protected $_defaultBackendOptions = array(
        'hashed_directory_level'    => 1,
        'hashed_directory_perm'    => 0777,
        'file_name_prefix'          => 'mage',
    );

    /**
     * List of available request processors
     *
     * @var array
     */
    protected $_requestProcessors = array();

    /**
     * Disallow cache saving
     *
     * @var bool
     */
    protected $_disallowSave = false;

    /**
     * List of allowed cache options
     *
     * @var array
     */
    protected $_allowedCacheOptions;


    /**
     * DB connection
     *
     * @var string|null
     */
    protected $_dbConnection = 'core_write';

    /**
     * Class constructor. Initialize cache instance based on options
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
    	
        $this->_defaultBackendOptions['cache_dir'] = isset($options['cache_dir']) ? $options['cache_dir'] :
            Mage::getBaseDir('cache');
        /**
         * Initialize id prefix
         */
        $this->_idPrefix = isset($options['id_prefix']) ? $options['id_prefix'] : '';
        if (empty($this->_idPrefix)) {
            $this->_idPrefix = substr(md5(Mage::getConfig()->getOptions()->getEtcDir()), 0, 3).'_';
        }

        $backend    = $this->_getBackendOptions($options); //使用什么缓存引擎
        $frontend   = $this->_getFrontendOptions($options); //生命周期、自动更新机制
		$this->_frontend = Varien_Cache::factory('Varien_Cache_Core', $backend['type'], $frontend, $backend['options'],
            true, true, true
        );

        if (isset($options['request_processors'])) {
            $this->_requestProcessors = $options['request_processors'];
        }

        if (isset($options['disallow_save'])) {
            $this->_disallowSave = (bool)$options['disallow_save'];
        }
    }

    /**
     * Get cache backend options. Result array contain backend type ('type' key) and backend options ('options')
     *
     * @param   array $cacheOptions
     * @return  array
     */
    protected function _getBackendOptions(array $cacheOptions)
    {
        $enable2levels = false; //是否启用两级缓存 数据对象缓存+opcode缓存
        $type   = isset($cacheOptions['backend']) ? $cacheOptions['backend'] : $this->_defaultBackend;
        if (isset($cacheOptions['backend_options']) && is_array($cacheOptions['backend_options'])) {
            $options = $cacheOptions['backend_options'];
        } else {
            $options = array();
        }
		//$type = default file
        $backendType = false;
        //XCache，APC，eAccelerator这三款都可以称为Opcode Cache
        switch (strtolower($type)) {
            case 'memcached':
            	//集群部署(分布式是才有效)
            	//它通过在内存中缓存数据和对象来减少读取数据库的次数，从而提高动态、数据库驱动网站的速度
            	//内存优化器
                if (extension_loaded('memcached')) {
                    if (isset($cacheOptions['memcached'])) {
                        $options = $cacheOptions['memcached'];
                    }
                    $enable2levels = true;
                    $backendType = 'Libmemcached';
                } elseif (extension_loaded('memcache')) {
                    if (isset($cacheOptions['memcached'])) {
                        $options = $cacheOptions['memcached'];
                    }
                    $enable2levels = true;
                    $backendType = 'Memcached';
                }
                break;
            case 'apc':
                if (extension_loaded('apc') && ini_get('apc.enabled')) {
                    $enable2levels = true;
                    $backendType = 'Apc';
                }
                break;
            case 'xcache':
            	//php加速器
            	//XCache 是一个又快又稳定的 PHP opcode 缓存器
                if (extension_loaded('xcache')) {
                    $enable2levels = true;
                    $backendType = 'Xcache';
                }
                break;
            case 'eaccelerator':
            case 'varien_cache_backend_eaccelerator':
            	//php加速器
            	//eAccelerator主要用于单机PHP提速
                if (extension_loaded('eaccelerator') && ini_get('eaccelerator.enable')) {
                    $enable2levels = true;
                    $backendType = 'Varien_Cache_Backend_Eaccelerator';
                }
                break;
            case 'varien_cache_backend_database':
            case 'database':
                $backendType = 'Varien_Cache_Backend_Database';
                $options = $this->getDbAdapterOptions($options);
                break;
            default:
                $backendType = false;
        }

        if (!$backendType) {
        	//默认使用File做缓存
            $backendType = $this->_defaultBackend;
            foreach ($this->_defaultBackendOptions as $option => $value) {
                if (!array_key_exists($option, $options)) {
                    $options[$option] = $value;
                }
            }
        }
		
        $backendOptions = array('type' => $backendType, 'options' => $options);
        if ($enable2levels) {
            $backendOptions = $this->_getTwoLevelsBackendOptions($backendOptions, $cacheOptions);
        }
        return $backendOptions;
    }

    /**
     * Get options for database backend type
     *
     * @param array $options
     * @return array
     */
    protected function getDbAdapterOptions(array $options = array())
    {
        if (isset($options['connection'])) {
            $this->_dbConnection = $options['connection'];
        }

        $options['adapter_callback'] = array($this, 'getDbAdapter');
        $options['data_table'] = Mage::getSingleton('core/resource')->getTableName('core/cache');
        $options['tags_table'] = Mage::getSingleton('core/resource')->getTableName('core/cache_tag');
        return $options;
    }

    /**
     * Initialize two levels backend model options
     *
     * @param array $fastOptions fast level backend type and options
     * @param array $cacheOptions all cache options
     * @return array
     */
    protected function _getTwoLevelsBackendOptions($fastOptions, $cacheOptions)
    {
        $options = array();
        $options['fast_backend']                = $fastOptions['type'];
        $options['fast_backend_options']        = $fastOptions['options'];
        $options['fast_backend_custom_naming']  = true;
        $options['fast_backend_autoload']       = true;
        $options['slow_backend_custom_naming']  = true;
        $options['slow_backend_autoload']       = true;

        if (isset($cacheOptions['auto_refresh_fast_cache'])) {
            $options['auto_refresh_fast_cache'] = (bool)$cacheOptions['auto_refresh_fast_cache'];
        } else {
            $options['auto_refresh_fast_cache'] = false;
        }
        if (isset($cacheOptions['slow_backend'])) {
            $options['slow_backend'] = $cacheOptions['slow_backend'];
        } else {
            $options['slow_backend'] = $this->_defaultBackend;
        }
        if (isset($cacheOptions['slow_backend_options'])) {
            $options['slow_backend_options'] = $cacheOptions['slow_backend_options'];
        } else {
            $options['slow_backend_options'] = $this->_defaultBackendOptions;
        }
        if ($options['slow_backend'] == 'database') {
            $options['slow_backend'] = 'Varien_Cache_Backend_Database';
            $options['slow_backend_options'] = $this->getDbAdapterOptions($options['slow_backend_options']);
            if (isset($cacheOptions['slow_backend_store_data'])) {
                $options['slow_backend_options']['store_data'] = (bool)$cacheOptions['slow_backend_store_data'];
            } else {
                $options['slow_backend_options']['store_data'] = false;
            }
        }

        $backend = array(
            'type'      => 'TwoLevels',
            'options'   => $options
        );
        return $backend;
    }

    /**
     * Get options of cache frontend (options of Zend_Cache_Core)
     *
     * @param   array $cacheOptions
     * @return  array
     */
    protected function _getFrontendOptions(array $cacheOptions)
    {
        $options = isset($cacheOptions['frontend_options']) ? $cacheOptions['frontend_options'] : array();
        if (!array_key_exists('caching', $options)) {
            $options['caching'] = true;
        }
        if (!array_key_exists('lifetime', $options)) {
            $options['lifetime'] = isset($cacheOptions['lifetime']) ? $cacheOptions['lifetime']
                : self::DEFAULT_LIFETIME;
        }
        if (!array_key_exists('automatic_cleaning_factor', $options)) {
            $options['automatic_cleaning_factor'] = 0;
        }
        $options['cache_id_prefix'] = $this->_idPrefix;
        return $options;
    }

    /**
     * Prepare unified valid identifier with prefix
     *
     * @param   string $id
     * @return  string
     */
    protected function _id($id)
    {
        if ($id) {
            $id = strtoupper($id);
        }
        return $id;
    }

    /**
     * Prepare cache tags.
     *
     * @param   array $tags
     * @return  array
     */
    protected function _tags($tags = array())
    {
        foreach ($tags as $key => $value) {
            $tags[$key] = $this->_id($value);
        }
        return $tags;
    }

    /**
     * Get cache frontend API object
     *
     * @return Varien_Cache_Core
     */
    public function getFrontend()
    {
        return $this->_frontend;
    }

    /**
     * Load data from cache by id
     *
     * @param   string $id
     * @return  string
     */
    public function load($id)
    {
        return $this->getFrontend()->load($this->_id($id));
    }

    /**
     * Save data
     *
     * @param string $data
     * @param string $id
     * @param array $tags
     * @param int $lifeTime
     * @return bool
     */
    public function save($data, $id, $tags = array(), $lifeTime = null)
    {
        if ($this->_disallowSave) {
            return true;
        }

        /**
         * Add global magento cache tag to all cached data exclude config cache
         */
        if (!in_array(Mage_Core_Model_Config::CACHE_TAG, $tags)) {
            $tags[] = Mage_Core_Model_App::CACHE_TAG;
        }
        return $this->getFrontend()->save((string)$data, $this->_id($id), $this->_tags($tags), $lifeTime);
    }

    /**
     * Remove cached data by identifier
     *
     * @param   string $id
     * @return  bool
     */
    public function remove($id)
    {
        return $this->getFrontend()->remove($this->_id($id));
    }

    /**
     * Clean cached data by specific tag
     *
     * @param   array $tags
     * @return  bool
     */
    public function clean($tags=array())
    {
        $mode = Varien_Cache::CLEANING_MODE_MATCHING_ANY_TAG;
        if (!empty($tags)) {
            if (!is_array($tags)) {
                $tags = array($tags);
            }
            $res = $this->getFrontend()->clean($mode, $this->_tags($tags));
        } else {
            $res = $this->getFrontend()->clean($mode, array(Mage_Core_Model_App::CACHE_TAG));
            $res = $res && $this->getFrontend()->clean($mode, array(Mage_Core_Model_Config::CACHE_TAG));
        }
        return $res;
    }

    /**
     * Flush cached data
     *
     * @return  bool
     */
    public function flush()
    {
        $res = $this->getFrontend()->clean();
        return $res;
    }

    /**
     * Get adapter for database cache backend model
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function getDbAdapter()
    {
        return Mage::getSingleton('core/resource')->getConnection($this->_dbConnection);
    }

    /**
     * Get cache resource model
     *
     * @return Mage_Core_Model_Mysql4_Cache
     */
    protected function _getResource()
    {
        return Mage::getResourceSingleton('core/cache');
    }

    /**
     * Initialize cache types options
     *
     * @return Mage_Core_Model_Cache
     */
    protected function _initOptions()
    {
    	//是否已缓存缓存项的数据
        $options = $this->load(self::OPTIONS_CACHE_ID);
		
        if ($options === false) {
            $options = $this->_getResource()->getAllOptions();
            if (is_array($options)) {
                $this->_allowedCacheOptions = $options;
                $this->save(serialize($this->_allowedCacheOptions), self::OPTIONS_CACHE_ID);
            } else {
                $this->_allowedCacheOptions = array();
            }
        } else {
            $this->_allowedCacheOptions = unserialize($options);
        }

        if (Mage::getConfig()->getOptions()->getData('global_ban_use_cache')) {
            foreach ($this->_allowedCacheOptions as $key => $val) {
                $this->_allowedCacheOptions[$key] = false;
            }
        }

        return $this;
    }

    /**
     * Save cache usage options
     *
     * @param array $options
     * @return Mage_Core_Model_Cache
     */
    public function saveOptions($options)
    {
        $this->remove(self::OPTIONS_CACHE_ID);
        $this->_getResource()->saveAllOptions($options);
        return $this;
    }

    /**
     * Check if cache can be used for specific data type
     *
     * @param string $typeCode
     * @return bool
     */
    public function canUse($typeCode)
    {
        if (is_null($this->_allowedCacheOptions)) {
            $this->_initOptions();
        }
		
        if (empty($typeCode)) {
            return $this->_allowedCacheOptions;
        }

        if (isset($this->_allowedCacheOptions[$typeCode])) {
            return (bool)$this->_allowedCacheOptions[$typeCode];
        } else {
            return false;
        }
    }

    /**
     * Disable cache usage for specific data type
     *
     * @param string $typeCode
     * @return Mage_Core_Model_Cache
     */
    public function banUse($typeCode)
    {
        $this->_allowedCacheOptions[$typeCode] = false;
        return $this;
    }

    /**
     * Get cache tags by cache type from configuration
     *
     * @param string $type
     * @return array
     */
    public function getTagsByType($type)
    {
        $path = self::XML_PATH_TYPES . '/' . $type . '/tags';
        $tagsConfig = Mage::getConfig()->getNode($path);
        if ($tagsConfig) {
            $tags = (string) $tagsConfig;
            $tags = explode(',', $tags);
        } else {
            $tags = false;
        }
        return $tags;
    }

    /**
     * Get information about all declared cache types
     *
     * @return array
     */
    public function getTypes()
    {
        $types = array();
        $config = Mage::getConfig()->getNode(self::XML_PATH_TYPES);
        if ($config) {
            foreach ($config->children() as $type=>$node) {
                $types[$type] = new Varien_Object(array(
                    'id'            => $type,
                    'cache_type'    => Mage::helper('core')->__((string)$node->label),
                    'description'   => Mage::helper('core')->__((string)$node->description),
                    'tags'          => strtoupper((string) $node->tags),
                    'status'        => (int)$this->canUse($type),
                ));
            }
        }
        return $types;
    }

    /**
     * Get invalidate types codes
     *
     * @return array
     */
    protected function _getInvalidatedTypes()
    {
        $types = $this->load(self::INVALIDATED_TYPES);
        if ($types) {
            $types = unserialize($types);
        } else {
            $types = array();
        }
        return $types;
    }

    /**
     * Save invalidated cache types
     *
     * @param array $types
     * @return Mage_Core_Model_Cache
     */
    protected function _saveInvalidatedTypes($types)
    {
        $this->save(serialize($types), self::INVALIDATED_TYPES);
        return $this;
    }

    /**
     * Get array of all invalidated cache types
     *
     * @return array
     */
    public function getInvalidatedTypes()
    {
        $invalidatedTypes = array();
        $types = $this->_getInvalidatedTypes();
        if ($types) {
            $allTypes = $this->getTypes();
            foreach ($types as $type => $flag) {
                if (isset($allTypes[$type]) && $this->canUse($type)) {
                    $invalidatedTypes[$type] = $allTypes[$type];
                }
            }
        }
        return $invalidatedTypes;
    }

    /**
     * Mark specific cache type(s) as invalidated
     *
     * @param string|array $typeCode
     * @return Mage_Core_Model_Cache
     */
    public function invalidateType($typeCode)
    {
        $types = $this->_getInvalidatedTypes();
        if (!is_array($typeCode)) {
            $typeCode = array($typeCode);
        }
        foreach ($typeCode as $code) {
            $types[$code] = 1;
        }
        $this->_saveInvalidatedTypes($types);
        return $this;
    }

    /**
     * Clean cached data for specific cache type
     *
     * @param string $typeCode
     * @return Mage_Core_Model_Cache
     */
    public function cleanType($typeCode)
    {
        $tags = $this->getTagsByType($typeCode);
        $this->clean($tags);

        $types = $this->_getInvalidatedTypes();
        unset($types[$typeCode]);
        $this->_saveInvalidatedTypes($types);
        return $this;
    }

    /**
     * Try to get response body from cache storage with predefined processors
     *
     * @return bool
     */
    public function processRequest()
    {
        if (empty($this->_requestProcessors)) {
            return false;
        }

        $content = false;
        foreach ($this->_requestProcessors as $processor) {
            $processor = $this->_getProcessor($processor);
            if ($processor) {
                $content = $processor->extractContent($content);
            }
        }

        if ($content) {
            Mage::app()->getResponse()->appendBody($content);
            return true;
        }
        return false;
    }

    /**
     * Get request processor object
     */
    protected function _getProcessor($processor)
    {
        return new $processor;
    }
}

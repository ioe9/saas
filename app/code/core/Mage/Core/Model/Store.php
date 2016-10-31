<?php
class Mage_Core_Model_Store
{
    /**
     * Configuration pathes
     */
    const XML_PATH_STORE_STORE_NAME       = 'general/store_information/name';
    /**
     *
     */
    const XML_PATH_STORE_STORE_PHONE      = 'general/store_information/phone';
    /**
     *
     */
    const XML_PATH_STORE_STORE_HOURS      = 'general/store_information/hours';
    /**
     *
     */
    const XML_PATH_STORE_IN_URL           = 'web/url/use_store';
    /**
     *
     */
    const XML_PATH_USE_REWRITES           = 'web/seo/use_rewrites';
    /**
     *
     */
    const XML_PATH_UNSECURE_BASE_URL      = 'web/unsecure/base_url';
    /**
     *
     */
    const XML_PATH_SECURE_BASE_URL        = 'web/secure/base_url';
    /**
     *
     */
    const XML_PATH_SECURE_IN_FRONTEND     = 'web/secure/use_in_frontend';
    /**
     *
     */
    const XML_PATH_SECURE_IN_ADMINHTML    = 'web/secure/use_in_adminhtml';
    /**
     *
     */
    const XML_PATH_SECURE_BASE_LINK_URL   = 'web/secure/base_link_url';
    /**
     *
     */
    const XML_PATH_UNSECURE_BASE_LINK_URL = 'web/unsecure/base_link_url';
    /**
     *
     */
    const XML_PATH_OFFLOADER_HEADER       = 'web/secure/offloader_header';
    /**
     *
     */
    const XML_PATH_PRICE_SCOPE            = 'catalog/price/scope';

    /**
     * Price scope constants
     */
    const PRICE_SCOPE_GLOBAL              = 0;
    /**
     *
     */
    const PRICE_SCOPE_WEBSITE             = 1;

    /**
     * Possible URL types
     */
    const URL_TYPE_LINK                   = 'link';
    /**
     *
     */
    const URL_TYPE_DIRECT_LINK            = 'direct_link';
    /**
     *
     */
    const URL_TYPE_WEB                    = 'web';
    /**
     *
     */
    const URL_TYPE_SKIN                   = 'skin';
    /**
     *
     */
    const URL_TYPE_JS                     = 'js';
    /**
     *
     */
    const URL_TYPE_MEDIA                  = 'media';

    /**
     * Code constants
     */
    const DEFAULT_CODE                    = 'default';
    /**
     *
     */
    const ADMIN_CODE                      = 'admin';

    /**
     * Cache tag
     */
    const CACHE_TAG                       = 'store';

    /**
     * Cookie name
     */
    const COOKIE_NAME                     = 'store';

    /**
     * Cookie currency key
     */
    const COOKIE_CURRENCY                 = 'currency';

    /**
     * Script name, which returns all the images
     */
    const MEDIA_REWRITE_SCRIPT            = 'get.php/';

    /**
     * Cache flag
     *
     * @var boolean
     */
    protected $_cacheTag    = true;

    /**
     * Event prefix for model events
     *
     * @var string
     */
    protected $_eventPrefix = 'store';

    /**
     * Event object name
     *
     * @var string
     */
    protected $_eventObject = 'store';

    /**
     * Price filter
     *
     * @var Mage_Directory_Model_Currency_Filter
     */
    protected $_priceFilter;


    /**
     * Store configuration cache
     *
     * @var array|null
     */
    protected $_configCache = null;

    /**
     * Base nodes of store configuration cache
     *
     * @var array
     */
    protected $_configCacheBaseNodes = array();

    /**
     * Directory cache
     *
     * @var array
     */
    protected $_dirCache = array();

    /**
     * URL cache
     *
     * @var array
     */
    protected $_urlCache = array();

    /**
     * Base URL cache
     *
     * @var array
     */
    protected $_baseUrlCache = array();

    /**
     * Session entity
     *
     * @var Mage_Core_Model_Session_Abstract
     */
    protected $_session;

    /**
     * Flag that shows that backend URLs are secure
     *
     * @var boolean|null
     */
    protected $_isAdminSecure = null;

    /**
     * Flag that shows that frontend URLs are secure
     *
     * @var boolean|null
     */
    protected $_isFrontSecure = null;

    /**
     * Store frontend name
     *
     * @var string|null
     */
    protected $_frontendName = null;

    /**
     * Readonly flag
     *
     * @var bool
     */
    private $_isReadOnly = false;

    /**
     * Initialize object
     */
    protected function _construct()
    {
    }
    
    
    public function getUrl($route = '', $params = array())
    {
        /** @var $url Mage_Core_Model_Url */
        $url = Mage::getModel('core/url')
            ->setStore($this);
        if (Mage::app()->getStore()->getId() != $this->getId()) {
            $params['_store_to_url'] = true;
        }

        return $url->getUrl($route, $params);
    }
    
    protected function _updatePathUseRewrites($url)
    {
        if ($this->isAdmin() || !Mage::app()->getStoreConfig(self::XML_PATH_USE_REWRITES) || !Mage::isInstalled()) {
            $indexFileName = $this->_isCustomEntryPoint() ? 'index.php' : basename($_SERVER['SCRIPT_FILENAME']);
            $url .= $indexFileName . '/';
        }
        return $url;
    }

    protected function _isCustomEntryPoint()
    {
        return (bool)Mage::registry('custom_entry_point');
    }
    /**
     * Retrieve base URL
     *
     * @param string $type
     * @param boolean|null $secure
     * @return string
     */
    public function getBaseUrl($type = self::URL_TYPE_LINK, $secure = null)
    {
        $cacheKey = $type . '/' . (is_null($secure) ? 'null' : ($secure ? 'true' : 'false'));
        if (!isset($this->_baseUrlCache[$cacheKey])) {
            switch ($type) {
                case self::URL_TYPE_WEB:
                    $secure = is_null($secure) ? $this->isCurrentlySecure() : (bool)$secure;
                    $url = Mage::app()->getStoreConfig('web/' . ($secure ? 'secure' : 'unsecure') . '/base_url');
                    $url = MAGE_HOST.'';
                    break;

                case self::URL_TYPE_LINK:
                    $secure = (bool) $secure;
                    //$url = Mage::app()->getStoreConfig('web/' . ($secure ? 'secure' : 'unsecure') . '/base_link_url');
                    $url = MAGE_HOST.'';
                    $url = $this->_updatePathUseRewrites($url);
                    break;

                case self::URL_TYPE_DIRECT_LINK:
                    $secure = (bool) $secure;
                    $url = Mage::app()->getStoreConfig('web/' . ($secure ? 'secure' : 'unsecure') . '/base_link_url');
                    $url = $this->_updatePathUseRewrites($url);
                    break;

                case self::URL_TYPE_SKIN:
                	$url = MAGE_HOST.'skin/';
                	break;
                case self::URL_TYPE_JS:
                    $secure = is_null($secure) ? $this->isCurrentlySecure() : (bool) $secure;
                    $url = Mage::app()->getStoreConfig('web/' . ($secure ? 'secure' : 'unsecure') . '/base_' . $type . '_url');
                    //echo 'web/' . ($secure ? 'secure' : 'unsecure') . '/base_' . $type . '_url'."<br/>";
                    $url = MAGE_HOST.'js/';
                    break;

                case self::URL_TYPE_MEDIA:
                    //$url = $this->_updateMediaPathUseRewrites($secure);
                    $url = MAGE_HOST.'media/';
                    break;

                default:
                    throw Mage::exception('Mage_Core', Mage::helper('core')->__('Invalid base url type'));
            }

            if (false !== strpos($url, '{{base_url}}')) {
                $baseUrl = Mage::getConfig()->substDistroServerVars('{{base_url}}');
                $url = str_replace('{{base_url}}', $baseUrl, $url);
            }
			
            $this->_baseUrlCache[$cacheKey] = rtrim($url, '/') . '/';
        }

        return $this->_baseUrlCache[$cacheKey];
    }
    
    public function isAdmin() {
    	return true;
    }
    public function getId() {
    	return 0;
    }
    public function getCode() {
    	return 'admin';
    }
    public function isCurrentlySecure() {
    	return false;
    }
     public function isAdminUrlSecure() {
    	return false;
    }
}

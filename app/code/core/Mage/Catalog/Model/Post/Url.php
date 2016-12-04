<?php
class Mage_Catalog_Model_Post_Url extends Varien_Object
{
    const CACHE_TAG = 'url_rewrite';

    /**
     * URL instance
     *
     * @var Mage_Core_Model_Url
     */
    protected  $_url;

    /**
     * URL Rewrite Instance
     *
     * @var Mage_Core_Model_Url_Rewrite
     */
    protected $_urlRewrite;

    /**
     * Factory instance
     *
     * @var Mage_Catalog_Model_Factory
     */
    protected $_factory;

    /**
     * @var Mage_Core_Model_Store
     */
    protected $_store;

    /**
     * Initialize Url model
     *
     * @param array $args
     */
    public function __construct(array $args = array())
    {
        $this->_factory = !empty($args['factory']) ? $args['factory'] : Mage::getSingleton('catalog/factory');
        $this->_store = !empty($args['store']) ? $args['store'] : Mage::app()->getStore();
    }

    /**
     * Retrieve URL Instance
     *
     * @return Mage_Core_Model_Url
     */
    public function getUrlInstance()
    {
        if (null === $this->_url) {
            $this->_url = Mage::getModel('core/url');
        }
        return $this->_url;
    }

    /**
     * Retrieve URL Rewrite Instance
     *
     * @return Mage_Core_Model_Url_Rewrite
     */
    public function getUrlRewrite()
    {
        if (null === $this->_urlRewrite) {
            $this->_urlRewrite = $this->_factory->getUrlRewriteInstance();
        }
        return $this->_urlRewrite;
    }

    /**
     * 'no_selection' shouldn't be a valid image attribute value
     *
     * @param string $image
     * @return string
     */
    protected function _validImage($image)
    {
        if($image == 'no_selection') {
            $image = null;
        }
        return $image;
    }

    /**
     * Retrieve URL in current store
     *
     * @param Mage_Catalog_Model_Post $post
     * @param array $params the URL route params
     * @return string
     */
    public function getUrlInStore(Mage_Catalog_Model_Post $post, $params = array())
    {
        $params['_store_to_url'] = true;
        return $this->getUrl($post, $params);
    }

    /**
     * Retrieve Post URL
     *
     * @param  Mage_Catalog_Model_Post $post
     * @param  bool $useSid forced SID mode
     * @return string
     */
    public function getPostUrl($post, $useSid = null)
    {
        if ($useSid === null) {
            $useSid = Mage::app()->getUseSessionInUrl();
        }

        $params = array();
        if (!$useSid) {
            $params['_nosid'] = true;
        }

        return $this->getUrl($post, $params);
    }

    /**
     * Format Key for URL
     *
     * @param string $str
     * @return string
     */
    public function formatUrlKey($str)
    {
        $urlKey = preg_replace('#[^0-9a-z]+#i', '-', Mage::helper('catalog/post_url')->format($str));
        $urlKey = strtolower($urlKey);
        $urlKey = trim($urlKey, '-');

        return $urlKey;
    }

    /**
     * Retrieve Post Url path (with category if exists)
     *
     * @param Mage_Catalog_Model_Post $post
     * @param Mage_Catalog_Model_Category $category
     *
     * @return string
     */
    public function getUrlPath($post, $category=null)
    {
        $path = $post->getData('url_path');

        if (is_null($category)) {
            /** @todo get default category */
            return $path;
        } elseif (!$category instanceof Mage_Catalog_Model_Category) {
            Mage::throwException('Invalid category object supplied');
        }

        return Mage::helper('catalog/category')->getCategoryUrlPath($category->getUrlPath())
            . '/' . $path;
    }

    /**
     * Retrieve Post URL using UrlDataObject
     *
     * @param Mage_Catalog_Model_Post $post
     * @param array $params
     * @return string
     */
    public function getUrl(Mage_Catalog_Model_Post $post, $params = array())
    {
        $url = $post->getData('url');
        if (!empty($url)) {
            return $url;
        }

        $requestPath = $post->getData('request_path');
        if (empty($requestPath)) {
            $requestPath = $this->_getRequestPath($post, $this->_getCategoryIdForUrl($post, $params));
            $post->setRequestPath($requestPath);
        }

        if (isset($params['_store'])) {
            $storeId = $this->_getStoreId($params['_store']);
        } else {
            $storeId = $post->getStoreId();
        }

        if ($storeId != $this->_getStoreId()) {
            $params['_store_to_url'] = true;
        }

        // reset cached URL instance GET query params
        if (!isset($params['_query'])) {
            $params['_query'] = array();
        }

        $this->getUrlInstance()->setStore($storeId);
        $postUrl = $this->_getPostUrl($post, $requestPath, $params);
        $post->setData('url', $postUrl);
        return $post->getData('url');
    }

    /**
     * Returns checked store_id value
     *
     * @param int|null $id
     * @return int
     */
    protected function _getStoreId($id = null)
    {
        return Mage::app()->getStore($id)->getId();
    }

    /**
     * Check post category
     *
     * @param Mage_Catalog_Model_Post $post
     * @param array $params
     *
     * @return int|null
     */
    protected function _getCategoryIdForUrl($post, $params)
    {
        if (isset($params['_ignore_category'])) {
            return null;
        } else {
            return $post->getCategoryId() && !$post->getDoNotUseCategoryId()
                ? $post->getCategoryId() : null;
        }
    }

    /**
     * Retrieve post URL based on requestPath param
     *
     * @param Mage_Catalog_Model_Post $post
     * @param string $requestPath
     * @param array $routeParams
     *
     * @return string
     */
    protected function _getPostUrl($post, $requestPath, $routeParams)
    {
        if (!empty($requestPath)) {
            return $this->getUrlInstance()->getDirectUrl($requestPath, $routeParams);
        }
        $routeParams['id'] = $post->getId();
        $routeParams['s'] = $post->getUrlKey();
        $categoryId = $this->_getCategoryIdForUrl($post, $routeParams);
        if ($categoryId) {
            $routeParams['category'] = $categoryId;
        }
        return $this->getUrlInstance()->getUrl('catalog/post/view', $routeParams);
    }

    /**
     * Retrieve request path
     *
     * @param Mage_Catalog_Model_Post $post
     * @param int $categoryId
     * @return bool|string
     */
    protected function _getRequestPath($post, $categoryId)
    {
        $idPath = sprintf('post/%d', $post->getEntityId());
        if ($categoryId) {
            $idPath = sprintf('%s/%d', $idPath, $categoryId);
        }
        $rewrite = $this->getUrlRewrite();
        $rewrite->setStoreId($post->getStoreId())
            ->loadByIdPath($idPath);
        if ($rewrite->getId()) {
            return $rewrite->getRequestPath();
        }

        return false;
    }
}

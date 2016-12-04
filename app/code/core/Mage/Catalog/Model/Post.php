<?php
class Mage_Catalog_Model_Post extends Mage_Catalog_Model_Abstract
{
	const STATUS_ENABLED    = 1;
    const STATUS_DISABLED   = 0;
    const CACHE_TAG              = 'catalog_post';
    protected $_cacheTag         = 'catalog_post';
    protected $_eventPrefix      = 'catalog_post';
    protected $_eventObject      = 'post';

    /**
     * Post Url Instance
     *
     * @var Mage_Catalog_Model_Post_Url
     */
    protected $_urlModel = null;
    protected static $_url;
    protected static $_urlRewrite;
    protected $_errors = array();
    /**
     * Initialize resources
     */
    protected function _construct()
    {
        $this->_init('catalog/post');
    }

    /**
     * Init mapping array of short fields to
     * its full names
     *
     * @return Varien_Object
     */
    protected function _initOldFieldsMap()
    {
        $this->_oldFieldsMap = Mage::helper('catalog')->getOldFieldMap();
        return $this;
    }

    /**
     * Get collection instance
     *
     * @return object
     */
    public function getResourceCollection()
    {
        if (empty($this->_resourceCollectionName)) {
            Mage::throwException(Mage::helper('catalog')->__('The model collection resource name is not defined.'));
        }
        $collection = Mage::getResourceModel($this->_resourceCollectionName);
        return $collection;
    }

    /**
     * Get post url model
     *
     * @return Mage_Catalog_Model_Post_Url
     */
    public function getUrlModel()
    {
        if ($this->_urlModel === null) {
            $this->_urlModel = Mage::getSingleton('catalog/factory')->getPostUrlInstance();
        }
        return $this->_urlModel;
    }

    /**
     * Validate Post Data
     *
     * @todo implement full validation process with errors returning which are ignoring now
     *
     * @return Mage_Catalog_Model_Post
     */
    public function validate()
    {
        //Mage::dispatchEvent($this->_eventPrefix.'_validate_before', array($this->_eventObject=>$this));
        $this->_getResource()->validate($this);
        //Mage::dispatchEvent($this->_eventPrefix.'_validate_after', array($this->_eventObject=>$this));
        return $this;
    }

    /**
     * Get post name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_getData('name');
    }

    /**
     * Get post status
     *
     * @return int
     */
    public function getStatus()
    {
        if (is_null($this->_getData('status'))) {
            $this->setData('status', Mage_Catalog_Model_Post_Status::STATUS_ENABLED);
        }
        return $this->_getData('status');
    }
    /**
     * Retrieve post category id
     *
     * @return int
     */
    public function getCategoryId()
    {
        if ($category = Mage::registry('current_category')) {
            return $category->getId();
        }
        return false;
    }

    /**
     * Retrieve post category
     *
     * @return Mage_Catalog_Model_Category
     */
    public function getCategory()
    {
        $category = $this->getData('category');
        if (is_null($category) && $this->getCategoryId()) {
            $category = Mage::getModel('catalog/category')->load($this->getCategoryId());
            $this->setCategory($category);
        }
        return $category;
    }

    /**
     * Set assigned category IDs array to post
     *
     * @param array|string $ids
     * @return Mage_Catalog_Model_Post
     */
    public function setCategoryIds($ids)
    {
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        } elseif (!is_array($ids)) {
            Mage::throwException(Mage::helper('catalog')->__('Invalid category IDs.'));
        }
        foreach ($ids as $i => $v) {
            if (empty($v)) {
                unset($ids[$i]);
            }
        }

        $this->setData('category_ids', $ids);
        return $this;
    }

    /**
     * Retrieve assigned category Ids
     *
     * @return array
     */
    public function getCategoryIds()
    {
        if (! $this->hasData('category_ids')) {
            $wasLocked = false;
          
            $ids = $this->_getResource()->getCategoryIds($this);
            
            $this->setData('category_ids', $ids);
            
        }

        return (array) $this->_getData('category_ids');
    }

    /**
     * Retrieve post categories
     *
     * @return Varien_Data_Collection
     */
    public function getCategoryCollection()
    {
        return $this->_getResource()->getCategoryCollection($this);
    }

    /**
     * Check post options and type options and save them, too
     */
    protected function _beforeSave()
    {
        $this->cleanCache();
        parent::_beforeSave();
    }

    /**
     * Saving post type related data and init index
     *
     * @return Mage_Catalog_Model_Post
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * Clear chache related with post and protect delete from not admin
     * Register indexing event before delete post
     *
     * @return Mage_Catalog_Model_Post
     */
    protected function _beforeDelete()
    {
        $this->_protectFromNonAdmin();
        $this->cleanCache();

        return parent::_beforeDelete();
    }

    /**
     * Init indexing process after post delete commit
     *
     * @return Mage_Catalog_Model_Post
     */
    protected function _afterDeleteCommit()
    {
        parent::_afterDeleteCommit();
    }

    /**
     * Retrieve resource instance wrapper
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Post
     */
    protected function _getResource()
    {
        return parent::_getResource();
    }

    /**
     * Clear cache related with post id
     *
     * @return Mage_Catalog_Model_Post
     */
    public function cleanCache()
    {
        Mage::app()->cleanCache('catalog_post_'.$this->getId());
        return $this;
    }
    /**
     * Retrieve Post URL
     *
     * @param  bool $useSid
     * @return string
     */
    public function getPostUrl($useSid = null)
    {

        return $this->getUrlModel()->getPostUrl($this, $useSid);
    }

    /**
     * Retrieve URL in current store
     *
     * @param array $params the route params
     * @return string
     */
    public function getUrlInStore($params = array())
    {
        return $this->getUrlModel()->getUrlInStore($this, $params);
    }

    /**
     * Formats URL key
     *
     * @param $str URL
     * @return string
     */
    public function formatUrlKey($str)
    {
        return $this->getUrlModel()->formatUrlKey($str);
    }

    /**
     * Retrieve Post Url Path (include category)
     *
     * @param Mage_Catalog_Model_Category $category
     * @return string
     */
    public function getUrlPath($category=null)
    {
        return $this->getUrlModel()->getUrlPath($this, $category);
    }

    /**
     * Delete post
     *
     * @return Mage_Catalog_Model_Post
     */
    public function delete()
    {
        parent::delete();
        Mage::dispatchEvent($this->_eventPrefix.'_delete_after_done', array($this->_eventObject=>$this));
        return $this;
    }

    /**
     * Returns request path
     *
     * @return string
     */
    public function getRequestPath()
    {
        if (!$this->_getData('request_path')) {
            $this->getPostUrl();
        }
        return $this->_getData('request_path');
    }

    /**
     * Returns rating summary
     *
     * @return mixed
     */
    public function getRatingSummary()
    {
        return $this->_getData('rating_summary');
    }
    /**
     * Return Catalog Post Image helper instance
     *
     * @return Mage_Catalog_Helper_Image
     */
    protected function _getImageHelper()
    {
        return Mage::helper('catalog/image');
    }

    /**
     * Return re-sized image URL
     *
     * @deprecated since 1.1.5
     * @return string
     */
    public function getImageUrl()
    {
        return (string)$this->_getImageHelper()->init($this, 'image')->resize(265);
    }

    /**
     * Return re-sized small image URL
     *
     * @deprecated since 1.1.5
     * @param int $width
     * @param int $height
     * @return string
     */
    public function getSmallImageUrl($width = 88, $height = 77)
    {
        return (string)$this->_getImageHelper()->init($this, 'small_image')->resize($width, $height);
    }

    /**
     * Return re-sized thumbnail image URL
     *
     * @deprecated since 1.1.5
     * @param int $width
     * @param int $height
     * @return string
     */
    public function getThumbnailUrl($width = 75, $height = 75)
    {
        return (string)$this->_getImageHelper()->init($this, 'thumbnail')->resize($width, $height);
    }
    /**
     * Get cahce tags associated with object id
     *
     * @return array
     */
    public function getCacheIdTagsWithCategories()
    {
        $tags = $this->getCacheTags();
        $affectedCategoryIds = $this->_getResource()->getCategoryIds($this);
        foreach ($affectedCategoryIds as $categoryId) {
            $tags[] = Mage_Catalog_Model_Category::CACHE_TAG.'_'.$categoryId;
        }
        return $tags;
    }

    /**
     * Remove model onject related cache
     *
     * @return Mage_Core_Model_Abstract
     */
    public function cleanModelCache()
    {
        $tags = $this->getCacheIdTagsWithCategories();
        if ($tags !== false) {
            Mage::app()->cleanCache($tags);
        }
        return $this;
    }
    /**
     * Checks whether post has disabled status
     *
     * @return bool
     */
    public function isDisabled()
    {
        return $this->getStatus() == Mage_Catalog_Model_Post_Status::STATUS_DISABLED;
    }

    /**
     * Callback function which called after transaction commit in resource model
     *
     * @return Mage_Catalog_Model_Post
     */
    public function afterCommitCallback()
    {
        parent::afterCommitCallback();
        return $this;
    }
    
    static public function getStatusOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('catalog')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('catalog')->__('Disabled')
        );
    }
}

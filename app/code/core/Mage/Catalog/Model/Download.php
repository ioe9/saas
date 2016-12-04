<?php
class Mage_Catalog_Model_Download extends Mage_Catalog_Model_Abstract
{
	const STATUS_ENABLED    = 1;
    const STATUS_DISABLED   = 0;
    const CACHE_TAG              = 'catalog_download';
    protected $_cacheTag         = 'catalog_download';
    protected $_eventPrefix      = 'catalog_download';
    protected $_eventObject      = 'download';

    /**
     * Download Url Instance
     *
     * @var Mage_Catalog_Model_Download_Url
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
        $this->_init('catalog/download');
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
     * Get download url model
     *
     * @return Mage_Catalog_Model_Download_Url
     */
    public function getUrlModel()
    {
        if ($this->_urlModel === null) {
            $this->_urlModel = Mage::getSingleton('catalog/factory')->getDownloadUrlInstance();
        }
        return $this->_urlModel;
    }

    /**
     * Validate Download Data
     *
     * @todo implement full validation process with errors returning which are ignoring now
     *
     * @return Mage_Catalog_Model_Download
     */
    public function validate()
    {
        //Mage::dispatchEvent($this->_eventPrefix.'_validate_before', array($this->_eventObject=>$this));
        $this->_getResource()->validate($this);
        //Mage::dispatchEvent($this->_eventPrefix.'_validate_after', array($this->_eventObject=>$this));
        return $this;
    }

    /**
     * Get download name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_getData('name');
    }

    /**
     * Get download status
     *
     * @return int
     */
    public function getStatus()
    {
        if (is_null($this->_getData('status'))) {
            $this->setData('status', Mage_Catalog_Model_Download_Status::STATUS_ENABLED);
        }
        return $this->_getData('status');
    }
    /**
     * Retrieve download category id
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
     * Retrieve download category
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
     * Set assigned category IDs array to download
     *
     * @param array|string $ids
     * @return Mage_Catalog_Model_Download
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
     * Retrieve download categories
     *
     * @return Varien_Data_Collection
     */
    public function getCategoryCollection()
    {
        return $this->_getResource()->getCategoryCollection($this);
    }

    /**
     * Check download options and type options and save them, too
     */
    protected function _beforeSave()
    {
        $this->cleanCache();
        parent::_beforeSave();
    }

    /**
     * Saving download type related data and init index
     *
     * @return Mage_Catalog_Model_Download
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * Clear chache related with download and protect delete from not admin
     * Register indexing event before delete download
     *
     * @return Mage_Catalog_Model_Download
     */
    protected function _beforeDelete()
    {
        $this->_protectFromNonAdmin();
        $this->cleanCache();

        return parent::_beforeDelete();
    }

    /**
     * Init indexing process after download delete commit
     *
     * @return Mage_Catalog_Model_Download
     */
    protected function _afterDeleteCommit()
    {
        parent::_afterDeleteCommit();
    }

    /**
     * Retrieve resource instance wrapper
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Download
     */
    protected function _getResource()
    {
        return parent::_getResource();
    }

    /**
     * Clear cache related with download id
     *
     * @return Mage_Catalog_Model_Download
     */
    public function cleanCache()
    {
        Mage::app()->cleanCache('catalog_download_'.$this->getId());
        return $this;
    }
    /**
     * Retrieve Download URL
     *
     * @param  bool $useSid
     * @return string
     */
    public function getDownloadUrl($useSid = null)
    {
        return $this->getUrlModel()->getDownloadUrl($this, $useSid);
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
     * Retrieve Download Url Path (include category)
     *
     * @param Mage_Catalog_Model_Category $category
     * @return string
     */
    public function getUrlPath($category=null)
    {
        return $this->getUrlModel()->getUrlPath($this, $category);
    }

    /**
     * Delete download
     *
     * @return Mage_Catalog_Model_Download
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
            $this->getDownloadUrl();
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
     * Return Catalog Download Image helper instance
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
     * Checks whether download has disabled status
     *
     * @return bool
     */
    public function isDisabled()
    {
        return $this->getStatus() == Mage_Catalog_Model_Download_Status::STATUS_DISABLED;
    }

    /**
     * Callback function which called after transaction commit in resource model
     *
     * @return Mage_Catalog_Model_Download
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

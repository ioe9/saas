<?php
class Mage_Cms_Model_Slide extends Mage_Core_Model_Abstract
{
    const CACHE_TAG     = 'cms_slide';
    protected $_cacheTag= 'cms_slide';

    protected function _construct()
    {
        $this->_init('cms/slide');
    }

    /**
     * Prevent slides recursion
     *
     * @throws Mage_Core_Exception
     * @return Mage_Core_Model_Abstract
     */
    protected function _beforeSave()
    {
        $needle = 'slide_id="' . $this->getSlideId() . '"';
        if (false == strstr($this->getContent(), $needle)) {
            return parent::_beforeSave();
        }
        Mage::throwException(
            Mage::helper('cms')->__('The static slide content cannot contain  directive with its self.')
        );
    }
    
    public function getSlideOptions() {
    	$arr = array();
    	$collection = $this->getCollection();
    	foreach ($collection as $_slide) {
    		$arr[$_slide->getId()] = $_slide->getTitle();
    	}
    	return $arr;
    }
}

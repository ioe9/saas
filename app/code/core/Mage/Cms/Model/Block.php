<?php
class Mage_Cms_Model_Block extends Mage_Core_Model_Abstract
{
    const CACHE_TAG     = 'cms_block';
    protected $_cacheTag= 'cms_block';

    protected function _construct()
    {
        $this->_init('cms/block');
    }

    /**
     * Prevent blocks recursion
     *
     * @throws Mage_Core_Exception
     * @return Mage_Core_Model_Abstract
     */
    protected function _beforeSave()
    {
        $needle = 'block_id="' . $this->getBlockId() . '"';
        if (false == strstr($this->getContent(), $needle)) {
            return parent::_beforeSave();
        }
        Mage::throwException(
            Mage::helper('cms')->__('The static block content cannot contain  directive with its self.')
        );
    }
    
    public function getBlockOptions() {
    	$arr = array();
    	$collection = $this->getCollection();
    	foreach ($collection as $_block) {
    		$arr[$_block->getId()] = $_block->getTitle();
    	}
    	return $arr;
    }
}

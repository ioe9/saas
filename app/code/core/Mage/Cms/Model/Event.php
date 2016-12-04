<?php
class Mage_Cms_Model_Event extends Mage_Core_Model_Abstract
{
    const CACHE_TAG     = 'cms_event';
    protected $_cacheTag= 'cms_event';

    protected function _construct()
    {
        $this->_init('cms/event');
    }

    /**
     * Prevent events recursion
     *
     * @throws Mage_Core_Exception
     * @return Mage_Core_Model_Abstract
     */
    protected function _beforeSave()
    {
        $needle = 'event_id="' . $this->getSlideId() . '"';
        if (false == strstr($this->getContent(), $needle)) {
            return parent::_beforeSave();
        }
        Mage::throwException(
            Mage::helper('cms')->__('The static event content cannot contain  directive with its self.')
        );
    }
    
    public function getSlideOptions() {
    	$arr = array();
    	$collection = $this->getCollection();
    	foreach ($collection as $_event) {
    		$arr[$_event->getId()] = $_event->getTitle();
    	}
    	return $arr;
    }
}

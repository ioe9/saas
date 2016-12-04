<?php
/**
 * Cache cleaner backend model
 *
 */
class Mage_Adminhtml_Model_System_Config_Backend_Cache extends Mage_Core_Model_Config_Data
{
    /**
     * Cache tags to clean
     *
     * @var array
     */
    protected $_cacheTags = array();

    /**
     * Clean cache, value was changed
     *
     */
    protected function _afterSave()
    {
        if ($this->isValueChanged()) {
            Mage::app()->cleanCache($this->_cacheTags);
        }
    }
}

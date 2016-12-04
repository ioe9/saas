<?php



class Mage_Adminhtml_Model_System_Config_Backend_Layer_Children extends Mage_Core_Model_Config_Data
{
    protected function _afterSave()
    {
        Mage::getSingleton('catalogindex/indexer')->plainReindex();
        return $this;
    }
}

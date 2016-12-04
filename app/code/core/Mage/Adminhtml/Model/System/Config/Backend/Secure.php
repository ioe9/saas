<?php



class Mage_Adminhtml_Model_System_Config_Backend_Secure extends Mage_Core_Model_Config_Data
{
    /**
     * Clean compiled JS/CSS when updating configuration settings
     */
    protected function _afterSave()
    {
        if ($this->isValueChanged()) {
            Mage::getModel('core/design_package')->cleanMergedJsCss();
        }
    }
}

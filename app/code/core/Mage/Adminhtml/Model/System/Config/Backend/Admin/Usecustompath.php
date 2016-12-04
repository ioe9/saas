<?php
/**
 * Adminhtml backend model for "Use Custom Admin Path" option
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Backend_Admin_Usecustompath extends Mage_Core_Model_Config_Data
{
    /**
     * Check whether redirect should be set
     *
     * @return Mage_Adminhtml_Model_System_Config_Backend_Admin_Usecustompath
     */
    protected function _beforeSave()
    {
        if ($this->getOldValue() != $this->getValue()) {
            Mage::register('custom_admin_path_redirect', true, true);
        }

        return $this;
    }
}

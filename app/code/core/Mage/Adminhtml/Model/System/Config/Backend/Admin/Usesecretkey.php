<?php
/**
 * Adminhtml backend model for "Use secret key in Urls" option
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Backend_Admin_Usesecretkey extends Mage_Core_Model_Config_Data
{
    protected function _afterSave()
    {
        Mage::getSingleton('adminhtml/url')->renewSecretUrls();
        return $this;
    }
}

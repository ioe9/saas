<?php
/**
 * Adminhtml Directory currency backend model
 *
 * Allows dispatching before and after events for each controller action
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Backend_Currency_Default extends Mage_Adminhtml_Model_System_Config_Backend_Currency_Abstract
{
    /**
     * Check default currency is available in installed currencies
     * Check default currency is available in allowed currencies
     *
     * @return Mage_Adminhtml_Model_System_Config_Backend_Currency_Default
     */
    protected function _afterSave()
    {
        if (!in_array($this->getValue(), $this->_getInstalledCurrencies())) {
            Mage::throwException(Mage::helper('adminhtml')->__('Selected default display currency is not available in installed currencies.'));
        }

        if (!in_array($this->getValue(), $this->_getAllowedCurrencies())) {
            Mage::throwException(Mage::helper('adminhtml')->__('Selected default display currency is not available in allowed currencies.'));
        }

        return $this;
    }
}

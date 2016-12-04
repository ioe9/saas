<?php
/**
 * Source model of customer address types
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Source_Customer_Address_Type
{
    /**
     * Retrieve possible customer address types
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            Mage_Customer_Model_Address_Abstract::TYPE_BILLING => Mage::helper('adminhtml')->__('Billing Address'),
            Mage_Customer_Model_Address_Abstract::TYPE_SHIPPING => Mage::helper('adminhtml')->__('Shipping Address')
        );
    }
}

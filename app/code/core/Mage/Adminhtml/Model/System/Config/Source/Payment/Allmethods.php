<?php


class Mage_Adminhtml_Model_System_Config_Source_Payment_Allmethods
{
    public function toOptionArray()
    {
        $methods = Mage::helper('payment')->getPaymentMethodList(true, true, true);
        return $methods;
    }
}

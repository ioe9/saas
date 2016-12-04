<?php

class Mage_Adminhtml_Model_System_Config_Source_Shipping_Taxclass
{
    public function toOptionArray()
    {
        $options = Mage::getModel('tax/class_source_product')->toOptionArray();
        //array_unshift($options, array('value'=>'', 'label' => Mage::helper('tax')->__('None')));
        return $options;
    }

}

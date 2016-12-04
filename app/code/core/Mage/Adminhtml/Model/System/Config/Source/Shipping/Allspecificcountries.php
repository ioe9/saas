<?php



class Mage_Adminhtml_Model_System_Config_Source_Shipping_Allspecificcountries
{
    public function toOptionArray()
    {
        return array(
            array('value'=>0, 'label'=>Mage::helper('adminhtml')->__('All Allowed Countries')),
            array('value'=>1, 'label'=>Mage::helper('adminhtml')->__('Specific Countries')),
        );
    }
}

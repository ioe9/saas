<?php



class Mage_Adminhtml_Model_System_Config_Source_Price_Scope
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'0', 'label'=>Mage::helper('core')->__('Global')),
            array('value'=>'1', 'label'=>Mage::helper('core')->__('Website')),
        );
    }
}

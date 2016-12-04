<?php



class Mage_Adminhtml_Model_System_Config_Source_Enabledisable
{
    public function toOptionArray()
    {
        return array(
            array('value'=>1, 'label'=>Mage::helper('adminhtml')->__('Enable')),
            array('value'=>0, 'label'=>Mage::helper('adminhtml')->__('Disable')),
        );
    }
}

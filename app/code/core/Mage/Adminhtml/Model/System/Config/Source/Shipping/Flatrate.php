<?php



class Mage_Adminhtml_Model_System_Config_Source_Shipping_Flatrate
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'', 'label'=> Mage::helper('adminhtml')->__('None')),
            array('value'=>'O', 'label'=>Mage::helper('adminhtml')->__('Per Order')),
            array('value'=>'I', 'label'=>Mage::helper('adminhtml')->__('Per Item')),
        );
    }
}

<?php

class Mage_Adminhtml_Model_System_Config_Source_Web_Redirect
{

    public function toOptionArray()
    {
        return array(
            array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('No')),
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Yes (302 Found)')),
            array('value' => 301, 'label'=>Mage::helper('adminhtml')->__('Yes (301 Moved Permanently)')),
        );
    }

}

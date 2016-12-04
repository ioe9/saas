<?php

class Mage_Adminhtml_Model_System_Config_Source_Web_Protocol
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'', 'label'=>''),
            array('value'=>'http', 'label'=>Mage::helper('adminhtml')->__('HTTP (unsecure)')),
            array('value'=>'https', 'label'=>Mage::helper('adminhtml')->__('HTTPS (SSL)')),
        );
    }

}

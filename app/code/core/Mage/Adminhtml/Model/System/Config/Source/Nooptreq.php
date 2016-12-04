<?php

class Mage_Adminhtml_Model_System_Config_Source_Nooptreq
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'', 'label'=>Mage::helper('adminhtml')->__('No')),
            array('value'=>'opt', 'label'=>Mage::helper('adminhtml')->__('Optional')),
            array('value'=>'req', 'label'=>Mage::helper('adminhtml')->__('Required')),
        );
    }

}

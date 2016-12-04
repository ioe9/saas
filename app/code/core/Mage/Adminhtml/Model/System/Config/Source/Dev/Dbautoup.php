<?php

class Mage_Adminhtml_Model_System_Config_Source_Dev_Dbautoup
{
    public function toOptionArray()
    {
        return array(
            array('value'=>Mage_Core_Model_Resource::AUTO_UPDATE_ALWAYS, 'label' => Mage::helper('adminhtml')->__('Always (during development)')),
            array('value'=>Mage_Core_Model_Resource::AUTO_UPDATE_ONCE,   'label' => Mage::helper('adminhtml')->__('Only Once (version upgrade)')),
            array('value'=>Mage_Core_Model_Resource::AUTO_UPDATE_NEVER,  'label' => Mage::helper('adminhtml')->__('Never (production)')),
        );
    }

}

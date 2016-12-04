<?php


class Mage_Adminhtml_Model_System_Config_Source_Catalog_TimeFormat
{
    public function toOptionArray()
    {
        return array(
            array('value' => '12h', 'label' => Mage::helper('adminhtml')->__('12h AM/PM')),
            array('value' => '24h', 'label' => Mage::helper('adminhtml')->__('24h')),
        );
    }
}

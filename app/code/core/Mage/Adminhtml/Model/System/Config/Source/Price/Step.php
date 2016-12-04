<?php


class Mage_Adminhtml_Model_System_Config_Source_Price_Step
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => Mage_Catalog_Model_Layer_Filter_Price::RANGE_CALCULATION_AUTO,
                'label' => Mage::helper('adminhtml')->__('Automatic (equalize price ranges)')
            ),
            array(
                'value' => Mage_Catalog_Model_Layer_Filter_Price::RANGE_CALCULATION_IMPROVED,
                'label' => Mage::helper('adminhtml')->__('Automatic (equalize product counts)')
            ),
            array(
                'value' => Mage_Catalog_Model_Layer_Filter_Price::RANGE_CALCULATION_MANUAL,
                'label' => Mage::helper('adminhtml')->__('Manual')
            ),
        );
    }
}

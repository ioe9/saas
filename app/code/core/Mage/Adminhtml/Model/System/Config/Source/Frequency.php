<?php



class Mage_Adminhtml_Model_System_Config_Source_Frequency
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'always', 'label'=>Mage::helper('sitemap')->__('Always')),
            array('value'=>'hourly', 'label'=>Mage::helper('sitemap')->__('Hourly')),
            array('value'=>'daily', 'label'=>Mage::helper('sitemap')->__('Daily')),
            array('value'=>'weekly', 'label'=>Mage::helper('sitemap')->__('Weekly')),
            array('value'=>'monthly', 'label'=>Mage::helper('sitemap')->__('Monthly')),
            array('value'=>'yearly', 'label'=>Mage::helper('sitemap')->__('Yearly')),
            array('value'=>'never', 'label'=>Mage::helper('sitemap')->__('Never')),
        );
    }
}

<?php



class Mage_Adminhtml_Model_System_Config_Source_Catalog_ListMode
{
    public function toOptionArray()
    {
        return array(
            //array('value'=>'', 'label'=>''),
            array('value'=>'grid', 'label'=>Mage::helper('adminhtml')->__('Grid Only')),
            array('value'=>'list', 'label'=>Mage::helper('adminhtml')->__('List Only')),
            array('value'=>'grid-list', 'label'=>Mage::helper('adminhtml')->__('Grid (default) / List')),
            array('value'=>'list-grid', 'label'=>Mage::helper('adminhtml')->__('List (default) / Grid')),
        );
    }
}

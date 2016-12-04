<?php
/**
 * Catalog products per page on Grid mode source
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 */
class Mage_Adminhtml_Model_System_Config_Source_Product_Thumbnail
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'itself', 'label'=>Mage::helper('adminhtml')->__('Product Thumbnail Itself')),
            array('value'=>'parent', 'label'=>Mage::helper('adminhtml')->__('Parent Product Thumbnail')),
        );
    }
}

<?php
/**
 * Price types mode source
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Source_Product_Options_Price
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'fixed', 'label' => Mage::helper('adminhtml')->__('Fixed')),
            array('value' => 'percent', 'label' => Mage::helper('adminhtml')->__('Percent'))
        );
    }
}

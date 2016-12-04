<?php
/**
 * Adminhtml source reports event store filter
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Source_Reports_Scope
{
    /**
     * Scope filter
     */
    public function toOptionArray()
    {
        return array(
            array('value'=>'website', 'label'=>Mage::helper('adminhtml')->__('Website')),
            array('value'=>'group', 'label'=>Mage::helper('adminhtml')->__('Store')),
            array('value'=>'store', 'label'=>Mage::helper('adminhtml')->__('Store View')),
        );
    }

}

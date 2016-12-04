<?php
/**
 * Country grid filter
 *
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Country extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Select
{
    protected function _getOptions()
    {
        $options = Mage::getResourceModel('directory/country_collection')->load()->toOptionArray(false);
        array_unshift($options, array('value'=>'', 'label'=>Mage::helper('cms')->__('All Countries')));
        return $options;
    }
}

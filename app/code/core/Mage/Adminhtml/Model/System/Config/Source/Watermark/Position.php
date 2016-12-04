<?php
/**
 * Watermark position config source model
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Source_Watermark_Position
{

    /**
     * Get available options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'stretch',         'label' => Mage::helper('catalog')->__('Stretch')),
            array('value' => 'tile',            'label' => Mage::helper('catalog')->__('Tile')),
            array('value' => 'top-left',        'label' => Mage::helper('catalog')->__('Top/Left')),
            array('value' => 'top-right',       'label' => Mage::helper('catalog')->__('Top/Right')),
            array('value' => 'bottom-left',     'label' => Mage::helper('catalog')->__('Bottom/Left')),
            array('value' => 'bottom-right',    'label' => Mage::helper('catalog')->__('Bottom/Right')),
            array('value' => 'center',          'label' => Mage::helper('catalog')->__('Center')),
        );
    }

}

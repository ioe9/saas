<?php
/**
 * Configuration source model for Wysiwyg toggling
 *
 * @category    Mage
 * @package     Mage_Cms
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Source_Cms_Wysiwyg_Enabled
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => Mage_Cms_Model_Wysiwyg_Config::WYSIWYG_ENABLED,
                'label' => Mage::helper('cms')->__('Enabled by Default')
            ),
            array(
                'value' => Mage_Cms_Model_Wysiwyg_Config::WYSIWYG_HIDDEN,
                'label' => Mage::helper('cms')->__('Disabled by Default')
            ),
            array(
                'value' => Mage_Cms_Model_Wysiwyg_Config::WYSIWYG_DISABLED,
                'label' => Mage::helper('cms')->__('Disabled Completely')
            )
        );
    }
}

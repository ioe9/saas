<?php
/**
 * Source for email send method
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Source_Email_Method
{
    public function toOptionArray()
    {
        $options    = array(
            array(
                'value' => 'bcc',
                'label' => Mage::helper('adminhtml')->__('Bcc')
            ),
            array(
                'value' => 'copy',
                'label' => Mage::helper('adminhtml')->__('Separate Email')
            ),
        );
        return $options;
    }
}

<?php
/**
 * Send to a Friend Limit sending by Source
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Source_Checktype
{
    /**
     * Retrieve Check Type Option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => Mage_Sendfriend_Helper_Data::CHECK_IP,
                'label' => Mage::helper('adminhtml')->__('IP Address')
            ),
            array(
                'value' => Mage_Sendfriend_Helper_Data::CHECK_COOKIE,
                'label' => Mage::helper('adminhtml')->__('Cookie (unsafe)')
            ),
        );
    }
}

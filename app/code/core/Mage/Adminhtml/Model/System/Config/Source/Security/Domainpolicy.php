<?php


class Mage_Adminhtml_Model_System_Config_Source_Security_Domainpolicy
{
    /**
     * @var Mage_Adminhtml_Helper_Data
     */
    protected $_helper;

    /**
     * @param array $options
     */
    public function __construct($options = array())
    {
        $this->_helper = isset($options['helper']) ? $options['helper'] : Mage::helper('adminhtml');
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => Mage_Core_Model_Domainpolicy::FRAME_POLICY_ALLOW,
                'label' => $this->_helper->__('Enabled'),
            ),
            array(
                'value' => Mage_Core_Model_Domainpolicy::FRAME_POLICY_ORIGIN,
                'label' => $this->_helper->__('Only from same domain'),
            ),
        );
    }
}

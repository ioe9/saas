<?php
/**
 * Class Mage_Admin_Model_Block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Admin_Model_Block extends Mage_Core_Model_Abstract
{
    /**
     * Initialize variable model
     */
    protected function _construct()
    {
        $this->_init('admin/block');
    }

    /**
     * @return array|bool
     * @throws Exception
     * @throws Zend_Validate_Exception
     */
    public function validate()
    {
        $errors = array();

        if (!Zend_Validate::is($this->getBlockName(), 'NotEmpty')) {
            $errors[] = Mage::helper('adminhtml')->__('Block Name is required field.');
        }
        if (!Zend_Validate::is($this->getBlockName(), 'Regex', array('/^[-_a-zA-Z0-9\/]*$/'))) {
            $errors[] = Mage::helper('adminhtml')->__('Block Name is incorrect.');
        }

        if (!in_array($this->getIsAllowed(), array('0', '1'))) {
            $errors[] = Mage::helper('adminhtml')->__('Is Allowed is required field.');
        }

        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    /**
     * Check is block with such type allowed for parsinf via blockDirective method
     *
     * @param $type
     * @return int
     */
    public function isTypeAllowed($type)
    {
        /** @var Mage_Admin_Model_Resource_Block_Collection $collection */
        $collection = Mage::getResourceModel('admin/block_collection');
        $collection->addFieldToFilter('block_name', array('eq' => $type))
            ->addFieldToFilter('is_allowed', array('eq' => 1));
        return $collection->load()->count();
    }
}

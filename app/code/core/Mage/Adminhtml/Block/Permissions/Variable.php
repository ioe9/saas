<?php
/**
 * Variables block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Permissions_Variable extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Construct
     */
    public function __construct()
    {
        $this->_controller = 'permissions_variable';
        $this->_headerText = Mage::helper('adminhtml')->__('Variables');
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add new variable');
        parent::__construct();
    }

    /**
     * Prepare output HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        Mage::dispatchEvent('permissions_variable_html_before', array('block' => $this));
        return parent::_toHtml();
    }
}

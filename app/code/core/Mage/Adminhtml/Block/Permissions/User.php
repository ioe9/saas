<?php
class Mage_Adminhtml_Block_Permissions_User extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
    	
        $this->_controller = 'permissions_user';
        $this->_headerText = Mage::helper('adminhtml')->__('Users');
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add New User');
        parent::__construct();
    }

    /**
     * Prepare output HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        Mage::dispatchEvent('permissions_user_html_before', array('block' => $this));
        return parent::_toHtml();
    }
}

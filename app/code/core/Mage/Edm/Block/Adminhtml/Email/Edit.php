<?php
class Mage_Edm_Block_Adminhtml_Email_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_email';
    	$this->_blockGroup = 'edm';
        $this->_mode = 'edit';
        
        parent::__construct();
        
        $this->_removeButton('reset');
        $this->_removeButton('save');
        $this->setTemplate('edm/email/edit.phtml');
    }

    public function getHeaderText()
    {
        return "开发信编辑";
    }
    
    public function getBaseInfoForm() {
    	echo $this->getLayout()->createBlock('edm/adminhtml_email_edit_company_base')->toHtml();      
    }
    public function getAdvanceInfoForm() {
    	echo $this->getLayout()->createBlock('edm/adminhtml_email_edit_company_advance')->toHtml();      
    }

}
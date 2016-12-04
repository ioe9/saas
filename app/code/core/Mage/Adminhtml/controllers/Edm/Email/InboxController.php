<?php
class Mage_Adminhtml_Edm_Email_InboxController extends Mage_Adminhtml_Controller_Edm
{
	public function indexAction() {
		$this->loadLayout();
		$this->_title("收邮件");
		$this->_setActiveMenu('edm/email/inbox');
        Mage::helper('edm/company_init')->initDefaultTemplate(Mage::registry('current_company'));
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_email_client', 'email.client'));
		$this->renderLayout();
	}
    protected function _isAllowed()
    {
        //return Mage::getSingleton('admin/session')->isAllowed('email');
        return true;
    }
}

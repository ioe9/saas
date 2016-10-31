<?php
class Mage_Adminhtml_Edm_Email_ClientController extends Mage_Adminhtml_Controller_Edm
{
	public function indexAction() {
		$this->loadLayout();
		$this->_title("发邮件")->_title("给老客户发邮件");
		$this->_setActiveMenu('email');
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

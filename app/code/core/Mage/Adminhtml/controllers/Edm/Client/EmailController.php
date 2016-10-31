<?php
class Mage_Adminhtml_Edm_Client_EmailController extends Mage_Adminhtml_Controller_Edm {
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('client');
		$this->_title("客户邮件列表 - 客户");
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_company_client_email', 'client.email'));
		$this->renderLayout();
	}
	public function newAction() {
		$this->loadLayout();
		$this->_setActiveMenu('client');

        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_company_client_email_edit', 'client.email.edit'));
		$this->renderLayout();
	}
	public function saveAction() {
		$data = $this->getRequest()->getParams();
		$email = Mage::getModel('edm/company_client_email');
		if (isset($data['id']) && $data['id']) {
			$email->load($data['id']);
		}
		unset($data['id']);
		$email->addData($data);
		try {
			$email->save();
			$this->_getSession()->addSuccess('客户邮箱保存成功');
		} catch (Exception $e) {
			
			Mage::log('客户邮箱保存失败:#'.$email->getId(),false,'client.log');
			$this->_getSession()->addError($e->getMessage());
		}
		if ($this->getRequest()->getParam('back')) {
    		$this->_redirect('*/*/edit',array('id'=>$email->getId()));
    	} else {
    		$this->_redirect('*/*/index');
    	}
	}
	

    
	public function _isAllowed() {
    	return true;
	}
}
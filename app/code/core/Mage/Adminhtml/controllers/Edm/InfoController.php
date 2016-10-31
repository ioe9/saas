<?php
class Mage_Adminhtml_Edm_InfoController extends Mage_Adminhtml_Controller_Edm {
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('account');
		$this->_title("帐号设置")->_title("基本信息");
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_info', 'info'));
		$this->renderLayout();
	}
	
	public function saveAction() {
		$data = $this->getRequest()->getParams();
		$user = Mage::getSingleton('admin/session')->getUser();
		$company = Mage::registry('current_company');
		if (!$company || !$company->getId()) {
			$this->getResponse()->setBody(Varien_Json::encode(array('ret'=>-1,'msg'=>'对不起，会员帐号无效，请联系客服')));
			return;
		}
		$company->addData($data);
		try {
			$company->save();
			
			
			$this->_getSession()->addSuccess('保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError('对不起，保存失败，请联系客服');
			
		}
		
		$this->_redirect('*/*/index');
	}
	
	
	public function catAction() {
		$this->loadLayout();
		$this->_setActiveMenu('account');
		$this->_title("帐号设置")->_title("基本信息");
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_info_cat', 'info.cat'));
		$this->renderLayout();
	}
    
	public function _isAllowed() {
    	return true;
	}
}
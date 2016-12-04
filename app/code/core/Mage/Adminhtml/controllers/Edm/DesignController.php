<?php
class Mage_Adminhtml_Edm_DesignController extends Mage_Adminhtml_Controller_Edm {
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('design/list');
		$this->_title("主题大厅")->_title("主题列表");
		$this->renderLayout();
	}
	
	public function myAction() {
		$this->loadLayout();
		$this->_setActiveMenu('design/my');
		Mage::register('current_filter','my');
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_design', 'design'));
		$this->_title("主题大厅")->_title("我的主题");
		$this->renderLayout();
	}
	
	public function wishlistAction() {
		$this->loadLayout();
		$this->_setActiveMenu('design/wishlist');
		Mage::register('current_filter','wishlist');
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_design', 'design'));
		$this->_title("主题大厅")->_title("我的收藏");
		$this->renderLayout();
	}
	
	public function viewAction() {
    	$id = (int)$this->getRequest()->getParam('id');
    	$design = Mage::getModel('edm/templates_design')->load($id);
    	
    	Mage::register('current_design',$design);
    	if ($design->getId()) {
    		 $this->_title($this->__('查看主题详情'));
	        $this->loadLayout();
	        $this->_setActiveMenu('design/list');
	        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_design_view', 'design.view'));
	        $this->renderLayout();
    	} else {
    		$this->_getSession()->addError('主题已不存在，请重试。');
			$this->_redirect('*/*');
    	}
    }
    public function previewAction() {
    	$id = (int)$this->getRequest()->getParam('id');
    	$design = Mage::getModel('edm/templates_design')->load($id);
    	if ($design->getId()) {
    		$dirFile = Mage::helper('edm/media')->getLayoutFileDir();
    		echo file_get_contents($dirFile.$design->getData('design_filename'));
    	} else {
    		echo "主题已不存在";
    	}
    	
    }
	public function _isAllowed() {
    	return true;
	}
}
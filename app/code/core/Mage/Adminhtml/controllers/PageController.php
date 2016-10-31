<?php
class Mage_Adminhtml_PageController extends Mage_Adminhtml_Controller_Action {
	public function viewAction() {
		$key = $this->getRequest()->getParams('key');
		Mage::register('current_key',$key);
		$this->loadLayout();
		$this->_setActiveMenu('more');
		$this->renderLayout();
	}
	
	
	public function _isAllowed() {
    	return true;
	}
}
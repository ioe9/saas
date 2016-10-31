<?php
class Mage_Adminhtml_Edm_Community_TemplateController extends Mage_Adminhtml_Controller_Edm {
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('community');
		$this->renderLayout();
	}
	public function _isAllowed() {
    	return true;
	}
}
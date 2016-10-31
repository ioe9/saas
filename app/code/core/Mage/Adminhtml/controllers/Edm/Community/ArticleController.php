<?php
class Mage_Adminhtml_Edm_Community_ArticleController extends Mage_Adminhtml_Controller_Edm {
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('community');
		$this->renderLayout();
	}
	public function listAction() {
		$this->loadLayout();
		$this->_setActiveMenu('community');
		$this->renderLayout();
	}
	public function wxAction() {
		$this->loadLayout();
		$this->_setActiveMenu('community');
		$this->renderLayout();
	}
	public function viewAction() {
		$this->loadLayout();
		$id = $this->getRequest()->getParam('id',false);
		if ($id) {
			$article = Mage::getModel('edm/article')->load($id);
			if ($article->getId()) {
				Mage::register('current_article',$article);
			}
		}
		$this->_setActiveMenu('community');
		$this->renderLayout();
	}
	public function _isAllowed() {
    	return true;
	}
}
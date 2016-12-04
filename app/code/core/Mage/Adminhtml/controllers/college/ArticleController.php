<?php
class Mage_Adminhtml_College_ArticleController extends Mage_Adminhtml_Controller_College {
	public function indexAction() {
		$this->loadLayout();
		$this->_title($this->__('外贸干货 - 外贸学院'));
		$this->_setActiveMenu('article');
		$this->renderLayout();
	}
	public function listAction() {
		$id = $this->getRequest()->getParam('id',0);
		$category = Mage::getModel('college/article_category')->load($id);
		Mage::register('current_category',$category);
		$this->loadLayout();
		if ($category->getId()) {
			$this->_title($this->__($category->getName().' - 外贸干货 - 外贸学院'));
		} else {
			$this->_title($this->__('外贸干货 - 外贸学院'));
		}
		
		$this->_setActiveMenu('article');
		$this->renderLayout();
	}
	public function wxAction() {
		$this->loadLayout();
		$this->_title($this->__('微信公众号 - 外贸学院'));
		$this->_setActiveMenu('article');
		$this->renderLayout();
	}
	public function viewAction() {
		$this->loadLayout();
		$id = $this->getRequest()->getParam('id',false);
		if ($id) {
			$article = Mage::getModel('college/article')->load($id);
			if ($article->getId()) {
				Mage::register('current_article',$article);
			}
		}
		$this->_title($this->__('外贸干货 - 外贸学院'));
		$this->_setActiveMenu('article');
		$this->renderLayout();
	}
	public function _isAllowed() {
    	return true;
	}
}
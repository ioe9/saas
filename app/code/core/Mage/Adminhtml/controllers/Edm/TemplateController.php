<?php
class Mage_Adminhtml_Edm_TemplateController extends Mage_Adminhtml_Controller_Edm {
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('template/list');
		$this->_title("模板大厅")->_title("模板列表");
		$this->renderLayout();
	}
	public function myAction() {
		$this->loadLayout();
		$this->_setActiveMenu('template/my');
		Mage::register('current_filter','my');
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_template', 'template'));
		$this->_title("模板大厅")->_title("我的模板");
		$this->renderLayout();
	}
	public function wishlistAction() {
		$this->loadLayout();
		$this->_setActiveMenu('template/wishlist');
		Mage::register('current_filter','wishlist');
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_template', 'template'));
		
		$this->_title("模板大厅")->_title("我的收藏");
		$this->renderLayout();
	}
	
	
	public function _isAllowed() {
    	return true;
	}
	
	
	public function interspireActionBak() {
		$html = trim($this->getRequest()->getParam('html'));
		$name = trim($this->getRequest()->getParam('name'));	
		$imageUrl = trim($this->getRequest()->getParam('img'));
		if (!$name) {
			echo "empty";die();
		}
		$filename = uniqid();
		$dir = Mage::helper('edm/media')->getLayoutFileDir();
		$dirImage = Mage::helper('edm/media')->getLayoutImageDir();
		$io = new Varien_Io_File();
		$io->cd($dir);
		$io->write($filename.'.html',$html);
		
		$io->cd($dirImage);
		$io->write($filename.'.gif',$imageUrl);
		
		$layout = Mage::getModel('edm/templates_layout');
		$data = array(
			'layout_name' => $name,
			'layout_desc' => $filename,
		);
		$layout->addData($data);
		try {
			$layout->save();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function imageActionBak() {
		$name = trim($this->getRequest()->getParam('name'));
		$img = trim($this->getRequest()->getParam('img'));
		$dir = Mage::helper('edm/media')->getLayoutImageDir();
		$io = new Varien_Io_File();
		$io->cd($dir);
		//$io->write($filename.'.html',$html);
		
		
		$c = Mage::getResourceModel('edm/templates_layout_collection')
			->addFieldToFilter('layout_name',$name)
			->setPageSize(1)
			->getFirstItem();
		
		
		$filename = $c->getData('layout_desc');
		$io->write($filename.'.gif',$img);
		
		
	}
}
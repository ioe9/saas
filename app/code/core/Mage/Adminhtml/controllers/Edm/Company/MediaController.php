<?php
class Mage_Adminhtml_Edm_Company_MediaController extends Mage_Adminhtml_Controller_Edm
{
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('account');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_company_media', 'media'));
		$this->renderLayout();
	}
	public function listAction() {
		$this->loadLayout();
		$this->_setActiveMenu('account');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_company_media', 'media'));
		$this->renderLayout();
	}
	public function newAction() {
		$this->_forward('edit');
	}
	public function editAction() {
		$id = $this->getRequest()->getParam('id',false);
		$this->loadLayout();
		$this->_setActiveMenu('account');
		$media = Mage::getModel('edm/company_media');
		if ($id) {
			$media->load($id);
		}
		Mage::register('current_media',$media);
		
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_company_media_edit', 'media.edit'));
		$this->renderLayout();
	}
	
    public function deleteAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$media = Mage::getModel('edm/company_media')->load($id);
    
    	try {
    		 $media->delete();
    		 $this->_getSession()->addSuccess("删除成功");
    	} catch(Exception $e) {
    		$this->_getSession()->addError();
    	}
    	$this->_redirect('*/*/index');
    }
    protected function _isAllowed()
    {
    	return true;
        ///return Mage::getSingleton('admin/session')->isAllowed('product');
    }
    
	public function getTmpFilePath()
    {
        //return Mage::helper('plan')->getBaseMediaDir(). DS . 'plan' . DS . 'product' .DS .'a' .DS;
        return Mage::getBaseDir('media'). DS . 'wysiwyg' . '' . DS . 'product' .DS;
    }
    public function getFileUrl($path) {
    	return 'media/wysiwyg/product/'.str_replace(DS,'/',$path);
    }
}

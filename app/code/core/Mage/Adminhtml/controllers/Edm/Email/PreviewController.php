<?php
class Mage_Adminhtml_Edm_Email_PreviewController extends Mage_Adminhtml_Controller_Edm
{
	public function indexAction() {
		$templateId = $this->getRequest()->getParam('tid');
		$template = Mage::getModel('edm/templates')->load($templateId);
		Mage::register('current_template',$template);

		$this->loadLayout();
		$this->_setActiveMenu('email');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_email_preview', 'email.preview'));
		$this->renderLayout();
	}
	
	public function templateAction() {
		$this->_initCompany();
		$draftId = $this->getRequest()->getParam('id');
		$draft = Mage::getModel('edm/company_draft')->load($draftId);
		Mage::register('current_draft',$draft);

		$this->loadLayout();
		$this->_setActiveMenu('email');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_email_preview_template', 'email.preview'));
        $this->_addRight($this->getLayout()->createBlock('edm/adminhtml_email_preview_templates', 'email.previews'));
		$this->renderLayout();
	}
	public function draftAction() {
		$this->_initCompany();
		$draftId = $this->getRequest()->getParam('id');
		$draft = Mage::getModel('edm/company_draft')->load($draftId);
		Mage::register('current_draft',$draft,true);

		
		$layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('adminhtml_ins_email_preview_draft');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();
        echo $output;
	}
    protected function _isAllowed()
    {
        //return Mage::getSingleton('admin/session')->isAllowed('email');
        return true;
    }
}

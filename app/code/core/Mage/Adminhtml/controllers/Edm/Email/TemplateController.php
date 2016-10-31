<?php
class Mage_Adminhtml_Edm_Email_TemplateController extends Mage_Adminhtml_Controller_Edm
{
    public function indexAction()
    {
    	$this->loadLayout();
    	$this->_title("邮件模板")->_title("邮件");

        $this->_setActiveMenu('email');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_template_my', 'template'));
        $this->renderLayout();
    }
    public function newAction() {
    	$this->_forward('edit');
    }
    public function viewAction() {
    	$this->_forward('edit');
    }
    
    public function editAction()
    {
    	$templateId = (int)$this->getRequest()->getParam('id');
    	$this->loadLayout();
    	$this->_title("邮件模板")->_title("编辑/查看");
		$template = Mage::getModel('edm/company_template')->load($templateId);
		Mage::register('current_template',$template);
        $this->_setActiveMenu('email');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_template_edit', 'template.edit'));
        $this->renderLayout();
    }
    
    
}

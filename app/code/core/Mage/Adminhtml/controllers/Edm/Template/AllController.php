<?php
class Mage_Adminhtml_Edm_Template_AllController extends Mage_Adminhtml_Controller_Edm
{
    public function indexAction()
    {
    	$this->loadLayout();
        $session = Mage::getSingleton('admin/session');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_template', 'template'));
        
        $this->renderLayout();
    }
}

<?php
class Mage_Edm_Block_Adminhtml_Feedback_Edit extends Mage_Adminhtml_Block_Template
{
	protected function _prepareLayout()
    {
        parent::_prepareLayout();
        Mage::app()->getLayout()->getBlock('head')->setCanLoadCKEditor(true);
    }
    public function __construct()
    {
        $this->setTemplate('edm/feedback/form.phtml');
    }
    
    public function getFormHtml() {
    	return Mage::getBlockSingleton('edm/adminhtml_feedback_edit_form')->toHtml();
    }
   
}

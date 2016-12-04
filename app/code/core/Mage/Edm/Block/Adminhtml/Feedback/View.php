<?php
class Mage_Edm_Block_Adminhtml_Feedback_View extends Mage_Adminhtml_Block_Template
{
	
    public function __construct()
    {
       parent::_construct();
       $this->setTemplate('edm/feedback/view.phtml');

    }
    
    public function getFormHtml() {
    	//return Mage::app()->getLayout()->createBlock('edm/adminhtml_feedback_reply_form')->toHtml();
    }

}
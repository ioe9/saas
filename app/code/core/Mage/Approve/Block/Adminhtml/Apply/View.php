<?php
class Mage_Approve_Block_Adminhtml_Apply_View extends Mage_Adminhtml_Block_Template
{
	
    public function __construct()
    {
       parent::_construct();
       $this->setTemplate('approve/apply/view.phtml');

    }
    
    public function getReplyCollection(){
    	$collection = Mage::getResourceModel('approve/reply_collection')
    		->addFieldToFilter('reply_approve',Mage::registry('current_approve')->getId())
    		->setOrder('reply_id','desc');
		return $collection;
    }
    
    public function getFormHtml() {
    	return Mage::app()->getLayout()->createBlock('approve/adminhtml_apply_reply_form')->toHtml();
    }

}
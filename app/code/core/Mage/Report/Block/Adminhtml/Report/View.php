<?php
class Mage_Report_Block_Adminhtml_Report_View extends Mage_Adminhtml_Block_Template
{
	
    public function __construct()
    {
       parent::_construct();
       $this->setTemplate('report/view.phtml');

    }
    
    public function getReplyCollection(){
    	$collection = Mage::getResourceModel('report/reply_collection')
    		->addFieldToFilter('reply_report',Mage::registry('current_report')->getId())
    		->setOrder('reply_id','desc');
		return $collection;
    }
    
    public function getFormHtml() {
    	return Mage::app()->getLayout()->createBlock('report/adminhtml_report_reply_form')->toHtml();
    }

}
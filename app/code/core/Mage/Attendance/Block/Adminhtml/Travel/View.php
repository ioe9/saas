<?php
class Mage_Attendance_Block_Adminhtml_Travel_View extends Mage_Adminhtml_Block_Template
{
	
    public function __construct()
    {
       parent::_construct();
       $this->setTemplate('attendance/travel/view.phtml');

    }
    
    public function getReplyCollection(){
    	$collection = Mage::getResourceModel('attendance/reply_collection')
    		->addFieldToFilter('reply_attendance',Mage::registry('current_attendance')->getId())
    		->setOrder('reply_id','desc');
		return $collection;
    }
    
    public function getFormHtml() {
    	return Mage::app()->getLayout()->createBlock('attendance/adminhtml_travel_link_form')->toHtml();
    }

}
<?php
class Mage_Report_Block_Adminhtml_Report_View extends Mage_Adminhtml_Block_Template
{
	
    public function __construct()
    {
       parent::_construct();
       $this->setTemplate('attendance/fieldwork/view.phtml');

    }
    
    public function getFormHtml() {
    	return Mage::app()->getLayout()->createBlock('attendance/adminhtml_attendance_reply_form')->toHtml();
    }

}
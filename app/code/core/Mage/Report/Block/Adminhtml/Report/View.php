<?php
class Mage_Report_Block_Adminhtml_Report_View extends Mage_Adminhtml_Block_Template
{
	
    public function __construct()
    {
       parent::_construct();
       $this->setTemplate('report/view.phtml');

    }
    
    public function getFormHtml() {
    	return Mage::app()->getLayout()->createBlock('report/adminhtml_report_reply_form')->toHtml();
    }

}
<?php
class Mage_Edm_Block_Adminhtml_Info extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('edm/info/index.phtml');
    }
    
    public function getBaseInfoForm() {
    	echo $this->getLayout()->createBlock('edm/adminhtml_email_edit_company_base')->toHtml();      
    }
    public function getAdvanceInfoForm() {
    	echo $this->getLayout()->createBlock('edm/adminhtml_email_edit_company_advance')->toHtml();      
    }
}

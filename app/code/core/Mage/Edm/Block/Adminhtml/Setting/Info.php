<?php
class Mage_Edm_Block_Adminhtml_Setting_Info extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('edm/setting/info.phtml');
    }
    
    public function getBaseInfoForm() {
    	echo $this->getLayout()->createBlock('edm/adminhtml_setting_info_edit_form')->toHtml();      
    }
    public function getAdvanceInfoForm() {
    	echo $this->getLayout()->createBlock('edm/adminhtml_setting_info_edit_advance')->toHtml();      
    }
}

<?php
class Mage_Edm_Block_Adminhtml_Setting_Advantage_Edit extends Mage_Adminhtml_Block_Template
{
	protected function _prepareLayout()
    {
        parent::_prepareLayout();
        Mage::app()->getLayout()->getBlock('head')->setCanLoadCKEditor(true);
    }
    public function __construct()
    {
        $this->setTemplate('edm/setting/advantage.phtml');
    }
    
    public function getFormHtml() {
    	return Mage::getBlockSingleton('edm/adminhtml_setting_advantage_edit_form')->toHtml();
    }
   
}

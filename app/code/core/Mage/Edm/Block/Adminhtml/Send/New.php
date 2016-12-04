<?php
class Mage_Edm_Block_Adminhtml_Send_New extends Mage_Adminhtml_Block_Template
{
	protected $_pageSize = 20;
    public function __construct()
    {
        $this->setTemplate('edm/send/new.phtml');
    }
    
	public function getScenes() {
		return Mage::getModel('edm/template_scene')->getScenes();
	}
	
	public function getTemplateCollection() {
		return Mage::getResourceModel('edm/template_collection')
			->addFieldToFilter('is_active',1)
			->addFieldToFilter('is_global',1);
	}

}

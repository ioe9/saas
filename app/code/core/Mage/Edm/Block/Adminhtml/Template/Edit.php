<?php
class Mage_Edm_Block_Adminhtml_Template_Edit extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
    	$this->setTemplate('edm/email/template/edit.phtml');
        parent::__construct();
    }

    
	public function getModuleCollection() {
		$collection = Mage::getResourceModel('edm/template_module_collection')
			->setOrder('module_position','asc');
		return $collection;
	}
	
	public function getScenes() {
		return Mage::getModel('edm/template_scene')->getScenes();
	}
	


}
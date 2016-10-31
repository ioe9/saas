<?php
class Mage_Edm_Block_Adminhtml_Template_Edit extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
    	$this->setTemplate('edm/email/template/edit.phtml');
        parent::__construct();
    }

    
	public function getModuleCollection() {
		$collection = Mage::getResourceModel('edm/templates_module_collection')
			->setOrder('position','desc');
		return $collection;
	}

}
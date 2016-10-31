<?php
class Mage_Bulletin_Block_Adminhtml_Template_Edit extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
    	$this->setTemplate('bulletin/email/template/edit.phtml');
        parent::__construct();
    }

    
	public function getModuleCollection() {
		$collection = Mage::getResourceModel('bulletin/templates_module_collection')
			->setOrder('position','desc');
		return $collection;
	}

}
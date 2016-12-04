<?php
class Mage_Edm_Block_Adminhtml_Email_Preview_Template extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
       
        $this->setTemplate('edm/email/preview/template.phtml');
    }

	public function getLayouts() {
		$collection = Mage::getResourceModel('edm/template_design_collection');
		return $collection;
	}
}
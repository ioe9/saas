<?php
class Mage_Edm_Block_Adminhtml_Email_Preview_Templates extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
       
        $this->setTemplate('edm/email/preview/templates.phtml');
    }

	public function getLayouts() {
		$collection = Mage::getResourceModel('edm/templates_layout_collection');
		return $collection;
	}
}
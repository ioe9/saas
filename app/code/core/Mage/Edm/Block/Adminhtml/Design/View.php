<?php
class Mage_Edm_Block_Adminhtml_Design_View extends Mage_Adminhtml_Block_Template
{
	
    public function __construct()
    {
       parent::_construct();
       $this->setTemplate('edm/design/view.phtml');

    }

}
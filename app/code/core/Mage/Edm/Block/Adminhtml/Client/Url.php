<?php
class Mage_Edm_Block_Adminhtml_Client_Url extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        
        parent::__construct();
        $this->setTemplate('edm/client/url.phtml');
        
    }
}

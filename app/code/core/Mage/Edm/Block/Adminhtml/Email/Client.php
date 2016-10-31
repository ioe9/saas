<?php
class Mage_Edm_Block_Adminhtml_Email_Client extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('edm/email/client.phtml');
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        
        Mage::app()->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        
      
    }
    public function getEditor() {
    	echo $this->getLayout()->createBlock('adminhtml/template')->setTemplate('edm/email/editor_big.phtml')->toHtml();      
    }
}

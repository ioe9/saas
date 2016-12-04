<?php
class Mage_Edm_Block_Adminhtml_Send_Edit extends Mage_Adminhtml_Block_Template
{

    public function __construct()
    {
        $this->setTemplate('edm/send/edit.phtml');
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        
        Mage::app()->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        
      
    }
    public function getEditor() {
    	echo $this->getLayout()->createBlock('edm/adminhtml_send_editor')->setTemplate('edm/send/editor.phtml')->toHtml();      
    }
    

}

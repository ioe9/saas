<?php
class Mage_Edm_Block_Adminhtml_Analysis_Keyword extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('edm/analysis/keyword.phtml');
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        
        Mage::app()->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        
      
    }
    public function getEditor() {
    	echo $this->getLayout()->createBlock('adminhtml/template')->setTemplate('edm/analysis/editor.phtml')->toHtml();      
    }
}

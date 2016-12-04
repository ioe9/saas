<?php
class Mage_Document_Block_Adminhtml_Dir extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('document/dir.phtml');
    }
    
    protected function _prepareLayout(){
        parent::_prepareLayout();
        return $this;
    }
    
    public function getGridHtml() {
    	return $this->getLayout()
                ->createBlock('document/adminhtml_dir_grid', 'adminhtml_dir_ugrid')->toHtml();
    }

}

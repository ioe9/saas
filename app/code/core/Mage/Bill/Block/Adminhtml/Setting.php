<?php
class Mage_Bill_Block_Adminhtml_Setting extends Mage_Adminhtml_Block_Template
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bill/setting.phtml');
    }
    
    protected function _prepareLayout(){
        parent::_prepareLayout();
    }

}

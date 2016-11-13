<?php
class Mage_Bill_Block_Adminhtml_Reimburse_New extends Mage_Adminhtml_Block_Template
{
	protected $_pageSize = 20;
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bill/reimburse/new.phtml');
    }
    
    protected function _prepareLayout(){
        parent::_prepareLayout();
    }

}

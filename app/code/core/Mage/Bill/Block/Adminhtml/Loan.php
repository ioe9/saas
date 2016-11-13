<?php
class Mage_Bill_Block_Adminhtml_Loan extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_loan';
    	$this->_blockGroup = 'bill';
    	
		$this->_headerText = "我的借款";
    	
    	
        parent::__construct();
        
        $this->_updateButton('add', 'label', "新建借款");
    }
}

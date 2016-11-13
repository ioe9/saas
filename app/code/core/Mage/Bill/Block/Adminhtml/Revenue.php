<?php
class Mage_Bill_Block_Adminhtml_Revenue extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_revenue';
    	$this->_blockGroup = 'bill';
    	
		$this->_headerText = "营收列表";
    	
    	
        parent::__construct();
        
        $this->_updateButton('add', 'label', "营收录入");
    }
}

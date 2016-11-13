<?php
class Mage_Bill_Block_Adminhtml_Reimburse extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_reimburse';
    	$this->_blockGroup = 'bill';
    	
		$this->_headerText = "我的报销";
    	
    	
        parent::__construct();
        
        $this->_updateButton('add', 'label', "新建报销");
    }
}

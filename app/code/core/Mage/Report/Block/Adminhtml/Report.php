<?php
class Mage_Report_Block_Adminhtml_Report extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_report';
    	$this->_blockGroup = 'report';
    	$filter = Mage::registry('current_filter');
    	if ($filter=='submitto'){
    		$this->_headerText = "提交给我的报告";
    	} else if ($filter=='ccto') {
    		$this->_headerText = "抄送给我的报告";
    	} else if ($filter=='submit') {
    		$this->_headerText = "我提交的报告";
    	}
		
    	
        parent::__construct();
        
        $this->_updateButton('add', 'label', "新建工作报告");
    }
}

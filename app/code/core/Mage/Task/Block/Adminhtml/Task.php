<?php
class Mage_Task_Block_Adminhtml_Task extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_task';
    	$this->_blockGroup = 'task';
    	
		$this->_headerText = "任务 > 任务管理";
    	
        parent::__construct();
        
        
    }
}

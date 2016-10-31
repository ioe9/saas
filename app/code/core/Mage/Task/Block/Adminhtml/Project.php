<?php
class Mage_Task_Block_Adminhtml_Project extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_project';
    	$this->_blockGroup = 'task';
    	
		$this->_headerText = "任务 > 项目管理";
    	
        parent::__construct();
        
        
    }
}

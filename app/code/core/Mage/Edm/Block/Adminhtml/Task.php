<?php
class Mage_Edm_Block_Adminhtml_Task extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_task';
    	$this->_blockGroup = 'edm';
		$this->_headerText = "任务列表";
        parent::__construct();
        $this->_updateButton('add', 'label', '<i class="fa fa-plus-circle mr5"></i>'."提交新任务");
        
    }
    
    public function getWide() {
    	return true;
    }
}

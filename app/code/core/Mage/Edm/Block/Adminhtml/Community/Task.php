<?php
class Mage_Edm_Block_Adminhtml_Community_Task extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_community_task';
    	$this->_blockGroup = 'edm';
		$this->_headerText = "任务列表";
        parent::__construct();
        $this->_updateButton('add', 'label', "发布新任务");
        
    }
    
    public function getWide() {
    	return true;
    }
}

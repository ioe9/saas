<?php
class Mage_Task_Block_Adminhtml_Task_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_task';
    	$this->_blockGroup = 'task';
        $this->_mode = 'edit';
        
        parent::__construct();

    }

    public function getHeaderText()
    {
        return "任务管理";
    }
    


}
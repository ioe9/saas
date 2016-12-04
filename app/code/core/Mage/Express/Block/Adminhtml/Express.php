<?php
class Mage_Express_Block_Adminhtml_Express extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = "adminhtml_express";
    	$this->_blockGroup = "express";
		$this->_headerText = "快递单管理";
        parent::__construct();
        $this->_updateButton("add", "label", "新增快件");
    }
}

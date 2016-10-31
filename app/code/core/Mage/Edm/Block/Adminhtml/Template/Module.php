<?php
class Mage_Edm_Block_Adminhtml_Template_Module extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_template_module';
    	$this->_blockGroup = 'edm';
		$this->_headerText = "模版 - 模块管理";
        parent::__construct();
        $this->_removeButton('add'); //允许用户创建自己的模版
        
    }
}

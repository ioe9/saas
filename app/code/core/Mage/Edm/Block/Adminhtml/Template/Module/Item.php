<?php
class Mage_Edm_Block_Adminhtml_Template_Module_Item extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_template_module_item';
    	$this->_blockGroup = 'edm';
    	if (Mage::registry('use_my_filter')) {
    		$this->_headerText = "模版 - 模块管理 - ".$this->getModule()->getData('name')."<span class='fs16'>（自定义）</span>";
    	} else {
    		$this->_headerText = "模版 - 模块管理 - ".$this->getModule()->getData('name')."<span class='fs16'>（系统自带）</span>";
    	}
		
        parent::__construct();
        $this->_removeButton('add'); //允许用户创建自己的模版
        
    }
    
    public function getModule() {
    	return Mage::registry('current_module');
    }
}

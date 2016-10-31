<?php
class Mage_Edm_Block_Adminhtml_Template_My extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_template_my';
    	$this->_blockGroup = 'edm';
		$this->_headerText = "邮件模版管理";
        parent::__construct();
        $this->_updateButton('add','label','创建新模板');
        
    }
}

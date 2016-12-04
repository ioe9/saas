<?php
class Mage_Edm_Block_Adminhtml_Setting_Advantage extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_setting_advantage';
    	$this->_blockGroup = 'edm';
    	
		$this->_headerText = "优势分组管理";
    	
        parent::__construct();
        $this->_updateButton('add', 'label', '<i class="fa fa-plus-circle mr5"></i>'."新增分组");
        
    }
}

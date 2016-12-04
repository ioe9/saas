<?php
class Mage_Edm_Block_Adminhtml_Client_Group extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_client_group';
    	$this->_blockGroup = 'edm';
    	
		$this->_headerText = "客户分组";

        parent::__construct();
        $this->_updateButton('add', 'label', '<i class="fa fa-plus-circle mr5"></i>'."新增分组");
        
    }
}

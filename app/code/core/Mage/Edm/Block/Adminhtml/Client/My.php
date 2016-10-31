<?php
class Mage_Edm_Block_Adminhtml_Client_My extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_client';
    	$this->_blockGroup = 'edm';
    	
		$this->_headerText = "客户 - 我的客户列表";

        parent::__construct();
        
        
    }
}

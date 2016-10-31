<?php
class Mage_Edm_Block_Adminhtml_Email extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_email';
    	$this->_blockGroup = 'edm';
    	
		$this->_headerText = "开发信发送列表";
    	
        parent::__construct();
        
        
    }
}

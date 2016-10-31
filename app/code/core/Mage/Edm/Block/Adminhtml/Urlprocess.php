<?php
class Mage_Edm_Block_Adminhtml_Urlprocess extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_urlprocess';
    	$this->_blockGroup = 'edm';
    	
		$this->_headerText = "网址列表";
    	
        parent::__construct();
        
        
    }
}

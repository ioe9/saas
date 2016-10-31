<?php
class Mage_Edm_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_product';
    	$this->_blockGroup = 'edm';
    	
		$this->_headerText = "产品列表";
    	
        parent::__construct();
        
        
    }
}

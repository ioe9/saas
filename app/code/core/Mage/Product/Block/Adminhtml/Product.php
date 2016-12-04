<?php
class Mage_Product_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = "adminhtml_product";
    	$this->_blockGroup = "product";
		$this->_headerText = "产品";
        parent::__construct();
        $this->_updateButton("add", "label", "<i class='fa fa-plus-circle mr5'></i>新增产品");
    }
}

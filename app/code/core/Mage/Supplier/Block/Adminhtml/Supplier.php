<?php
class Mage_Supplier_Block_Adminhtml_Supplier extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = "adminhtml_supplier";
    	$this->_blockGroup = "supplier";
		$this->_headerText = "供应商";
        parent::__construct();
        $this->_updateButton("add", "label", "<i class='fa fa-plus-circle mr5'></i>新增供应商");
    }
}

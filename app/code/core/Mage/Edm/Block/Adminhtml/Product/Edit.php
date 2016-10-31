<?php
class Mage_Edm_Block_Adminhtml_Product_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_product';
    	$this->_blockGroup = 'edm';
        $this->_mode = 'edit';
        
        parent::__construct();

    }

    public function getHeaderText()
    {
        return "产品编辑";
    }
    


}
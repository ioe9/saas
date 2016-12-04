<?php
class Mage_Express_Block_Adminhtml_Express_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
    	$this->_objectId   = "express_id";
        $this->_controller = "adminhtml_express";
    	$this->_blockGroup = "express";
        parent::__construct();
        $this->_addButton("saveandcontinue", array(
                "label"     => '<i class="fa fa-save mr5"></i>'."保存并继续",
                "onclick"   => "saveAndContinueEdit()",
                "class"     => "btn btn-primary save",
            ), -100);
        $this->_formScripts[] = "
	            function saveAndContinueEdit(){
	                editForm.submit($('edit_form').action+'back/edit/');
	            }
	           
	        ";
        $this->setTemplate('widget/form/container_fieldgroup.phtml');
    }

    public function getHeaderText()
    {
        if (Mage::registry("current_express")->getId()) {
            return "编辑快件";
        } else {
            return "新建快件";
        }
    }
}

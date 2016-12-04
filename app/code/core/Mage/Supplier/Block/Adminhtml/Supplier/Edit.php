<?php
class Mage_Supplier_Block_Adminhtml_Supplier_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
    	$this->_objectId   = "supplier_id";
        $this->_controller = "adminhtml_supplier";
    	$this->_blockGroup = "supplier";
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
       $this->setTemplate("widget/form/container_fieldgroup.phtml");
    }

    public function getHeaderText()
    {
        if (Mage::registry("current_supplier")->getId()) {
            return "编辑";
        } else {
            return "新建";
        }
    }
}

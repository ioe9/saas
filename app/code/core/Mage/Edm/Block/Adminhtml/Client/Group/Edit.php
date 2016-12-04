<?php
class Mage_Edm_Block_Adminhtml_Client_Group_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
    	$this->_objectId   = 'group_id';
        $this->_controller = 'adminhtml_client_group';
    	$this->_blockGroup = 'edm';
		
        
        parent::__construct();
        $this->_addButton('saveandcontinue', array(
                'label'     => '<i class="fa fa-save mr5"></i>'."保存并继续",
                'onclick'   => 'saveAndContinueEdit()',
                'class'     => 'btn btn-primary',
            ), -100);
        $this->_formScripts[] = "
	            function saveAndContinueEdit(){
	                editForm.submit($('edit_form').action+'back/edit/');
	            }
	           
	        ";
    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_group')->getId()) {
            return "编辑分组:".$this->escapeHtml(Mage::registry('current_group')->getData('group_name'));
        }
        else {
            return '新建分组';
        }
    }
}
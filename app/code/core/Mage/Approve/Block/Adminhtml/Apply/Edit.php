<?php
class Mage_Approve_Block_Adminhtml_Apply_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	
    public function __construct()
    {
        $this->_objectId   = 'apply_id';
        $this->_controller = 'adminhtml_apply';
    	$this->_blockGroup = 'approve';
		
        
        parent::__construct();
        $this->_addButton('saveandcontinue', array(
                'label'     => "保存并继续",
                'onclick'   => 'saveAndContinueEdit()',
                'class'     => 'save',
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
        if (Mage::registry('current_apply')->getId()) {
            return "编辑申请:".$this->escapeHtml(Mage::registry('current_apply')->getApplyCode());
        }
        else {
            return '新建申请';
        }
    }

}
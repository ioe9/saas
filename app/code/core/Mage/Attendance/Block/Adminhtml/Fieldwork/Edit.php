<?php
class Mage_Attendance_Block_Adminhtml_Fieldwork_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	
    public function __construct()
    {
        $this->_objectId   = 'fieldwork_id';
        $this->_controller = 'adminhtml_fieldwork';
    	$this->_blockGroup = 'attendance';
		
        
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
        if (Mage::registry('current_fieldwork')->getId()) {
            return "编辑外勤申请:".$this->escapeHtml(Mage::registry('current_fieldwork')->getFieldworkCode());
        }
        else {
            return '新建外勤申请';
        }
    }

}
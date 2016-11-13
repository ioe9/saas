<?php
class Mage_Attendance_Block_Adminhtml_Overtime_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	
    public function __construct()
    {
        $this->_objectId   = 'overtime_id';
        $this->_controller = 'adminhtml_overtime';
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
        if (Mage::registry('current_overtime')->getId()) {
            return "编辑加班申请:".$this->escapeHtml(Mage::registry('current_overtime')->getOvertimeCode());
        }
        else {
            return '新建加班申请';
        }
    }

}
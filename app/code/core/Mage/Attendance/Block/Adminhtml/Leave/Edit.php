<?php
class Mage_Attendance_Block_Adminhtml_Leave_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	
    public function __construct()
    {
        $this->_objectId   = 'leave_id';
        $this->_controller = 'adminhtml_leave';
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
        if (Mage::registry('current_leave')->getId()) {
            return "编辑加班申请:".$this->escapeHtml(Mage::registry('current_leave')->getLeaveCode());
        }
        else {
            return '新建加班申请';
        }
    }

}
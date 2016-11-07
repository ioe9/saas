<?php
class Mage_Report_Block_Adminhtml_Report_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	
    public function __construct()
    {
        $this->_objectId   = 'report_id';
        $this->_controller = 'adminhtml_report';
    	$this->_blockGroup = 'report';
		
        
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
        if (Mage::registry('current_report')->getId()) {
            return "编辑工作报告:".$this->escapeHtml(Mage::registry('current_report')->getReportName());
        }
        else {
            return '新建工作报告';
        }
    }

}
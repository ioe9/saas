<?php
class Mage_Bill_Block_Adminhtml_Reimburse_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
    	$this->_objectId   = 'reimburse_id';
        $this->_controller = 'adminhtml_reimburse';
    	$this->_blockGroup = 'bill';
		
        
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
        if (Mage::registry('current_reimburse')->getId()) {
            return "编辑报销:".$this->escapeHtml(Mage::registry('current_reimburse')->getReportName());
        }
        else {
            return '新建报销';
        }
    }
}
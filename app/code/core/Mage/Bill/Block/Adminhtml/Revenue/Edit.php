<?php
class Mage_Bill_Block_Adminhtml_Revenue_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
    	$this->_objectId   = 'revenue_id';
        $this->_controller = 'adminhtml_revenue';
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
        if (Mage::registry('current_revenue')->getId()) {
            return "编辑营收:".$this->escapeHtml(Mage::registry('current_revenue')->getReportName());
        }
        else {
            return '新建营收';
        }
    }
}
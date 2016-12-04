<?php
class Mage_Edm_Block_Adminhtml_Feedback_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row)
    {
        $actions = array();
		
        if ($row->getData('feedback_company')==Mage::registry('current_company')->getId()) {
        	$actions[] = array(
	            'url'       =>  $this->getUrl('*/*/edit',array('id'=>$row->getId())),
	            'caption'   =>  "编辑",
	
	        );
        }
        
        $actions[] = array(
            'url'       =>  $this->getUrl('*/*/view',array('id'=>$row->getId())),
            'caption'   =>  "查看",

        );

        $this->getColumn()->setActions($actions);
        return parent::render($row);
    }
}

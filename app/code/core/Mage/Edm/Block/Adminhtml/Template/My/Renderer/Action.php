<?php
class Mage_Edm_Block_Adminhtml_Template_My_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row)
    {
		$actions = array();
		$status = $row->getData('template_status');
        $actions[] = array(
            'url'       =>  $this->getUrl('*/*/edit',array('id'=>$row->getId())),
            'caption'   =>  "编辑",
        );
        
        if ($status==Mage_Edm_Model_Company_Template::STATUS_ENABLE) {
        	$actions[] = array(
	            'url'       =>  $this->getUrl('*/*/disable',array('id'=>$row->getId())),
	            'caption'   =>  "禁用",
	        );
        } else {
        	$actions[] = array(
	            'url'       =>  $this->getUrl('*/*/enable',array('id'=>$row->getId())),
	            'caption'   =>  "启用",
	        );
        }
	        
        $this->getColumn()->setActions($actions);
        return parent::render($row);   
    }
}

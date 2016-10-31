<?php
class Mage_Edm_Block_Adminhtml_Urlprocess_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row)
    {
        $actions = array();
		$status = $row->getStatus();
     	if ($status==2) {
     		$actions[] = array(
	            'url'       =>  $this->getUrl('adminhtml/email/new',array('url'=>$row->getData('url'))),
	            'caption'   =>  "分析客户",
	            
	        );
     	}

	        

        $this->getColumn()->setActions($actions);
        return parent::render($row);
    }
}

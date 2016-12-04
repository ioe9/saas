<?php
class Mage_Edm_Block_Adminhtml_Setting_Advantage_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row)
    {
        $actions = array();
		
        
        $actions[] = array(
            'url'       =>  $this->getUrl('*/*/edit',array('id'=>$row->getId())),
            'caption'   =>  "编辑",

        );
        $actions[] = array(
            'url'       =>  $this->getUrl('*/*/disable',array('id'=>$row->getId())),
            'caption'   =>  "禁用",

        );

        $this->getColumn()->setActions($actions);
        return parent::render($row);
    }
}

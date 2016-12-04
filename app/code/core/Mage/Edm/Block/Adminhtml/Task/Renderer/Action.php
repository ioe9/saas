<?php
class Mage_Edm_Block_Adminhtml_Task_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row)
    {
       return '<a href="'.$this->getUrl('adminhtml/edm_task/view',array('id'=>$row->getData('task_id'))).'" title="点击查看详情" target="_blank">详情</a>';
    }
}

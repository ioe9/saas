<?php
class Mage_Edm_Block_Adminhtml_Client_Group_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row)
    {
        $str = '<a href="'.$this->getUrl('adminhtml/edm_client_group/view',array('id'=>$row->getData('group_id'))).'" title="点击查看详情" target="_blank" class="mr20">详情</a>';
    	$str .= '<a href="'.$this->getUrl('adminhtml/edm_client_group/edit',array('id'=>$row->getData('group_id'))).'" title="点击编辑" class="mr20">编辑</a>';
    	$str .= '<a href="'.$this->getUrl('adminhtml/edm_client_group/client',array('id'=>$row->getData('group_id'))).'" title="点击管理客户">管理客户</a>';
    	return $str;
    }
}

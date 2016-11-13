<?php
class Mage_Attendance_Block_Adminhtml_Leave_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
    	
        $str = '';

    	$str = '<a href="'.$this->getUrl('*/*/view',array('id'=>$row->getData('leave_id'),'back'=>$filter = Mage::registry('current_filter'))).'" title="查看">查看</a>';
        if ($row->getLeaveCreate()==Mage::registry('current_user')->getId()) {
        	$str .= '<a style="margin-left:15px;" href="'.$this->getUrl('*/*/edit',array('id'=>$row->getData('leave_id'),'back'=>$filter = Mage::registry('current_filter'))).'" title="编辑">编辑</a>';
        
        }
        return $str;
        
    }
}

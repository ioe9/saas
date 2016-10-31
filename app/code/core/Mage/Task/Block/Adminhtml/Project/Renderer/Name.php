<?php
class Mage_Task_Block_Adminhtml_Project_Renderer_Name extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return '<a href="'.$this->getUrl('adminhtml/project_view/').'" title="'.$row->getProjectName().'">'.$row->getProjectName().'</a>';
    }
}

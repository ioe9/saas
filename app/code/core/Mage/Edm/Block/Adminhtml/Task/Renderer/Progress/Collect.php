<?php
class Mage_Edm_Block_Adminhtml_Task_Renderer_Progress_Collect extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
    	
    	$pecent = intval($row->getData('task_finish')*100/$row->getData('task_total'));
    	return '<div class="progress">
					<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$pecent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$pecent.'%">
			  </div>
			</div>';
        
    }
}

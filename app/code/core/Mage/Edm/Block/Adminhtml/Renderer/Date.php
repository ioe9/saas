<?php
class Mage_Edm_Block_Adminhtml_Renderer_Date extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
    	$date = $this->_getValue($row);
    	if ($date && $date!='0000-00-00 00:00:00') {
    		return date('Y-m-d',strtotime($date));
    	} else {
    		return '';
    	}
    	
        
    }
}

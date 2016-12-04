<?php
class Mage_Adminhtml_Block_Widget_Grid_Renderer_Datetime extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row)
    {
    	$value = $this->_getValue($row);
    	echo substr($value,0,16);
	        
    }
}

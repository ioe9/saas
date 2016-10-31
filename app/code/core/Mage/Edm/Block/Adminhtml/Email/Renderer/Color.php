<?php
class Mage_Edm_Block_Adminhtml_Email_Renderer_Color extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Cha $row)
    {
    	$str = '';
    	$colorStr = trim(str_replace('#','',$row->getChaColor()));
    	if ($colorStr) {
    		$colorArr = explode(',',$colorStr);
	        if (count($colorArr)) {
	        	
	        	$str = '<table border="0" cellpadding="0" cellspacing="0">';
	        	$str .= "<col width='50%'/>";
	        	$str .= "<col width='50%'/>";
	        	$str .= "<tbody>";
	        	
	        	foreach ($colorArr as $_c) {
	        		if ($_c) {
	        			$tmp = str_replace('#','',$_c);
		        		$str .= "<tr><td style='background:#".$tmp."'></td><td>#".$tmp."</td>";
	        		} else {
	        			var_dump($_c);
	        		}
		        		
	        	}
	        	$str .= "</tbody>";
	        	$str .= "</table>";
	        }
    	} else {
    		$str = "不可替换颜色";
    	}
	        
        return $str;
    }
}

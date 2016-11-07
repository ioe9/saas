<?php
class Mage_Report_Model_Type extends Mage_Core_Model_Abstract
{
	
    protected function _construct()
    {
        $this->_init('report/type');
    }
    
	public function getAsOptionsArray() {
		$collection = $this->getCollection();
		$arr = array();
		foreach ($collection as $item) {
			$arr[$item->getId()] = $item->getTypeName();
		}
		if (!count($arr)) {
			$arr = array('0'=>'默认');
		}
		
		return $arr;
	}
	
	
	
}

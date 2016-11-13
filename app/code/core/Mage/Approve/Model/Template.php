<?php
class Mage_Approve_Model_Template extends Mage_Core_Model_Abstract
{
	
    protected function _construct()
    {
        $this->_init("approve/template");
    }
	
	public function getAsOptions() {
		$collection = $this->getCollection();
		$arr = array();
		foreach ($collection as $item) {
			$arr[$item->getId()] = $item->getTplName();
		}
		if (!count($arr)) {
			$arr = array('0'=>'申请类型');
		}
		
		return $arr;
	}
}

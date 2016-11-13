<?php
class Mage_Bill_Model_Setting_Type extends Mage_Core_Model_Abstract
{
	
    protected function _construct()
    {
        $this->_init("bill/setting_type");
    }
	
	public function getAsOptions() {
		$arr = array();
		$collection = $this->getCollection()
			->addFieldToFilter('type_company',Mage::registry('current_company')->getId(0))
			->setOrder('type_position','desc');
		foreach ($collection as $item) {
			$arr[$item->getId()] = $item->getTypeName();
		}
		return $arr;
	}
	
}

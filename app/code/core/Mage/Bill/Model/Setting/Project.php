<?php
class Mage_Bill_Model_Setting_Project extends Mage_Core_Model_Abstract
{
	
    protected function _construct()
    {
        $this->_init("bill/setting_project");
    }
	
	public function getAsOptions() {
		$arr = array();
		$collection = $this->getCollection()
			->addFieldToFilter('project_company',Mage::registry('current_company')->getId(0))
			->setOrder('project_position','desc');
		foreach ($collection as $item) {
			$arr[$item->getId()] = $item->getProjectName();
		}
		return $arr;
	}
}

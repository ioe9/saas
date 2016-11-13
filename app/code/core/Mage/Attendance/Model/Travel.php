<?php
class Mage_Attendance_Model_Travel extends Mage_Core_Model_Abstract
{
	const STATUS_DRAFT = 0;
	const STATUS_AUDIT = 1;
	const STATUS_DONE = 2;
	const STATUS_REFUSE = -1;
    protected function _construct()
    {
        $this->_init("attendance/travel");
    }
		    
    	
	/***
	 * 获取状态数组
	 */
	public function getStatusOptions() {
		return array(
			self::STATUS_DRAFT => '草稿',
			self::STATUS_AUDIT => '新申请',
			self::STATUS_DONE => '审批通过',
			self::STATUS_REFUSE => '驳回',
		);
	}
	public function getUserName() {
		return Mage::getModel('admin/user')->load($this->getTravelCreate())->getName();
	}
	
	
	public function getAuditCollection()
	{
		$collection = Mage::getResourceModel('attendance/travel_link_collection')
			->addFieldToFilter('link_object',$this->getId())
			->addFieldToFilter('link_type',Mage_Attendance_Model_Travel_Link::LINK_TYPE_TO);
		//echo $collection->getSelect();
		return $collection;
	}
	
	public function getCcCollection()
	{
		$collection = Mage::getResourceModel('attendance/travel_link_collection')
			->addFieldToFilter('link_object',$this->getId())
			->addFieldToFilter('link_type',Mage_Attendance_Model_Travel_Link::LINK_TYPE_CC);
		return $collection;
	}
}

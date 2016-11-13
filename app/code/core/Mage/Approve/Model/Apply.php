<?php
class Mage_Approve_Model_Apply extends Mage_Core_Model_Abstract
{
	const STATUS_DRAFT = 0;
	const STATUS_AUDIT = 1;
	const STATUS_DONE = 2;
	const STATUS_REFUSE = -1;
    protected function _construct()
    {
        $this->_init("approve/apply");
    }
	
		
	/***
	 * 获取编号
	 */
	public function getNextCodeIncrement() {
		$lastItem = $this->getCollection()
			->addFieldToFilter('apply_company',Mage::registry('current_company'))
			->addFieldToFilter('date_create',array('eg'=>date('Y-m-d',strtotime(Mage::getSingleton('core/date')->gmtDate()).' 00:00:00')))
			->setOrder('date_create','desc')
			->setPageSize(1)
			->getLastItem();
		return ($lastItem->getApplyCodeIncrement()+1);
	}
	
	/***
	 * 获取状态数组
	 */
	public function getStatusOptions() {
		return array(
			self::STATUS_DRAFT => '草稿',
			self::STATUS_AUDIT => '审批中',
			self::STATUS_DONE => '审批通过',
			self::STATUS_REFUSE => '驳回',
		);
	}
	
		
	/***
	 * 获取审批人
	 */
	public function getApplyObject() {
		return Mage::getModel('approve/apply_link')->getApplyLink($this->getId());
	}
	/***
	 * 获取汇报对象
	 */
	public function getApplyCc() {
		return Mage::getModel('approve/apply_link')->getApplyLink($this->getId(),Mage_Approve_Model_Apply_Link::LINK_TYPE_CC);
	}
	
	public function getUserName() {
		return Mage::getModel('admin/user')->load($this->getApplyCreate())->getName();
	}
	
	public function getAuditCollection()
	{
		$collection = Mage::getResourceModel('approve/apply_audit_collection')
			->addFieldToFilter('audit_apply',$this->getId());
		return $collection;
	}
	
	public function getCcCollection()
	{
		$collection = Mage::getResourceModel('approve/apply_link_collection')
			->addFieldToFilter('link_apply',$this->getId())
			->addFieldToFilter('link_type',Mage_Approve_Model_Apply_Link::LINK_TYPE_CC);
		return $collection;
	}
}

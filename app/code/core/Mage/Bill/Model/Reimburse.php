<?php
class Mage_Bill_Model_Reimburse extends Mage_Core_Model_Abstract
{
	const TYPE_NORMAL = 0; //日常报销
	const TYPE_TRAVEL = 1; //差旅费报销
	const TYPE_HUMAN = 2; //人力成本报销
	const TYPE_PAYMENT = 3; //对公付款
	
	const STATUS_REFUSE = -1; //驳回
	const STATUS_DRAFT = 0; //草稿
	const STATUS_AUDIT = 1; //审批中
	const STATUS_ACCOUNT = 2; //审批完成送财务
	const STATUS_FINISH = 3; //办结

	
    protected function _construct()
    {
        $this->_init("bill/reimburse");
    }
	
	public function getTypeOptions() {
		$arr = array(
			self::TYPE_NORMAL => '日常报销',
			self::TYPE_TRAVEL => '差旅费报销',
			self::TYPE_HUMAN => '人力成本报销',
			self::TYPE_PAYMENT => '对公付款',
		);		
		return $arr;
	}
	
	public function getStatusOptions() {
		$arr = array(
			self::STATUS_DRAFT => '草稿',
			self::STATUS_AUDIT => '审批中',
			self::STATUS_ACCOUNT => '审批完成送财务',
			self::STATUS_FINISH => '办结',
			self::STATUS_REFUSE => '驳回',
		);		
		return $arr;
	}
	
	/***
	 * 获取编号
	 */
	public function getNextCodeIncrement() {
		$lastItem = $this->getCollection()
			->addFieldToFilter('rei_company',Mage::registry('current_company'))
			->addFieldToFilter('date_create',array('eg'=>date('Y-m-d',strtotime(Mage::getSingleton('core/date')->gmtDate()).' 00:00:00')))
			->setOrder('date_create','desc')
			->setPageSize(1)
			->getLastItem();
		return ($lastItem->getReiCodeIncrement()+1);
	}
	
	/***
	 * 
	 */
	public function getItemCollection() {
		$collection = Mage::getResourceModel('bill/reimburse_item_collection')
			->addFieldToFilter('item_rei',$this->getId())
			->setOrder('date_create','desc');
		//echo $collection->getSelect();
		return $collection;
	}
}

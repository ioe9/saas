<?php
class Mage_Edm_Block_Adminhtml_Community_Article_Sidebar_New extends Mage_Core_Block_Template
{
	protected $_collection;

	public function getCollection(){
		if (!$this->_collection) {
			$collection = Mage::getResourceModel('edm/article_collection');
			$collection->addFieldToFilter('status',1)
				->setOrder('date_publish','desc')
				->setPageSize('12');
			$this->_collection = $collection;
		}
		return $this->_collection;
	}
}

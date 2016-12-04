<?php
class Mage_College_Block_Adminhtml_Article_Sidebar_New extends Mage_Core_Block_Template
{
	protected $_collection;

	public function getCollection(){
		if (!$this->_collection) {
			$collection = Mage::getResourceModel('college/article_collection');
			$collection->addFieldToFilter('status',1)
				->setOrder('date_publish','desc')
				->setPageSize('12');
			$this->_collection = $collection;
		}
		return $this->_collection;
	}
}

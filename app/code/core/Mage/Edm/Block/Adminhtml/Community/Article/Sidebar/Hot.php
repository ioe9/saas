<?php
class Mage_Edm_Block_Adminhtml_Community_Article_Sidebar_Hot extends Mage_Core_Block_Template
{
	protected $_collection;
	protected function _prepareLayout()
    {
		$this->getCollection();
    }

	public function getCollection(){
		if (!$this->_collection) {
			$collection = Mage::getResourceModel('edm/article_collection');
			$collection->addFieldToFilter('status',1)
				->addFieldToFilter('is_hot',1)
				->setOrder('position','desc')
				->setPageSize('12');
			$this->_collection = $collection;
		}
		return $this->_collection;
	}
}

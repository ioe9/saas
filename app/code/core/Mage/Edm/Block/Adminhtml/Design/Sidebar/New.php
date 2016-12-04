<?php
class Mage_Edm_Block_Adminhtml_Design_Sidebar_New extends Mage_Core_Block_Template
{
	protected $_collection;
	protected function _prepareLayout()
    {
		$this->getCollection();
    }

	public function getCollection(){
		if (!$this->_collection) {
			$collection = Mage::getSingleton('edm/template_design')
				->getCollection()
				->setPageSize(10)
				->setOrder('date_publish','desc');
			$this->_collection = $collection;
		}
		return $this->_collection;
	}
}

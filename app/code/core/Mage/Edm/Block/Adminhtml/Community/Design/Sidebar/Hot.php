<?php
class Mage_Edm_Block_Adminhtml_Community_Design_Sidebar_Hot extends Mage_Core_Block_Template
{
	protected $_collection;
	protected function _prepareLayout()
    {
		$this->getCollection();
    }

	public function getCollection(){
		if (!$this->_collection) {
			$collection = Mage::getSingleton('edm/community_design_layer')
				->getCollection();
			$this->_collection = $collection;
		}
		return $this->_collection;
	}
}

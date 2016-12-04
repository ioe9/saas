<?php
class Mage_Edm_Model_Design_Layer extends Varien_Object
{
	protected $_collection;
    public function getCollection()
    {
    	if (!$this->_collection) {
    		$collection = Mage::getResourceModel('edm/templates_design_collection');
    		$collection->addFieldToFilter('design_company',0);
    		$this->_collection = $collection;
    	}
        return $this->_collection;
    }
}

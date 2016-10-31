<?php
class Mage_Edm_Model_Community_Design_Layer extends Varien_Object
{
	protected $_collection;
    public function getCollection()
    {
    	if (!$this->_collection) {
    		$collection = Mage::getResourceModel('edm/templates_layout_collection');
    		$this->_collection = $collection;
    	}
        return $this->_collection;
    }
}

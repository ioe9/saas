<?php
class Mage_Edm_Model_Company_Group extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/company_group');
    }
    
    public function getAsOption() {
    	$collection = $this->getCollection();
    	$arr = array();
    	foreach ($collection as $_c) {
    		$arr[$_c->getId()] = $_c->getName();
    	}
    	return $arr;
    }
}

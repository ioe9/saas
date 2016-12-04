<?php
class Mage_Edm_Model_Company extends Mage_Core_Model_Abstract
{
	
    protected function _construct()
    {
        $this->_init("edm/company");
    }
	
	public function loadByCompany($companyId) {
		return $this->getCollection()
			->addFieldToFilter('company_id',$companyId)
			->getFirstItem();
	}
}

<?php
class Mage_Edm_Model_Client_Email extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/client_email');
    }
    
    public function loadByEmail($client,$email) {
    	return $this->getCollection()
    		->addFieldToFilter('email',$email)
    		->addFieldToFilter('client_id',$client->getId())
    		->getFirstItem();
    }
}

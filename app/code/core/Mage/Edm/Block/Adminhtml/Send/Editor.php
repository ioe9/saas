<?php
class Mage_Edm_Block_Adminhtml_Send_Editor extends Mage_Adminhtml_Block_Template
{
	protected $_accountCollection;
    public function getDefaultAccount() {
    	$collection = $this->getAccountCollection();
    	$arr = array();
    	$defaultAccount = false;
    	foreach ($collection as $item) {
    		if ($item->getData('account_user')==Mage::registry('current_user')->getId()) {
    			array_push($arr,$item);
    		}
    	}
    	if (count($arr)) {
    		foreach ($arr as $item) {
    			if ($item->getData('is_default')) {
    				$defaultAccount = $item;
    				break;
    			}
    		}
    		if (!$defaultAccount) {
    			$defaultAccount = $arr[0];
    		}
    	} else {
    		$obj = new Varien_Object();
    		$company =  Mage::registry('current_edm_company');
    		$obj->setData('account_email',$company->getData('company_email'));
    		$obj->setData('account_name',$company->getData('company_contact'));
    		$defaultAccount = $obj;
    	}
    	return $defaultAccount;
    }
    
    public function getAccountCollection() {
    	if (!$this->_accountCollection) {
    		$this->_accountCollection = Mage::getResourceModel('edm/company_account_collection')
	    		->addFieldToFilter('account_company',Mage::registry('current_company')->getId())
	    		->addFieldToFilter('account_status',1);
    	}
    	return $this->_accountCollection;
	    	
    }
}

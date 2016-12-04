<?php
class Mage_Edm_Model_Company_Template_Module_Link extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/company_template_module_link');
    }
    
    public function getItems() {
    	$itemCollection = Mage::getResourceModel('edm/company_template_module_item_collection')
    		->addFieldToFilter('item_link',$this->getId());
		//echo $itemCollection->getSelect();
		return $itemCollection;
    }
}

<?php
class Mage_Edm_Block_Adminhtml_Analysis_Summary extends Mage_Adminhtml_Block_Template
{
	public function getClient() {
		return Mage::registry('current_client');
	}
	
	public function getAttrOptions($attrId) {
		$attrOptions = Mage::getResourceModel('edm/client_attr_option_collection')
		->addFieldToFilter('attr_id',$attrId);
		$tmp = array();
		foreach ($attrOptions as $_option) {
			$tmp[$_option->getId()] = $_option;
		}
		return $tmp;
	}
}

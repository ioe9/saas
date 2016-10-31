<?php
class Mage_Edm_Block_Adminhtml_Client_Email extends Mage_Adminhtml_Block_Template
{
	public function getClient() {
		return Mage::registry('current_client');
	}
	
	
}

<?php
class Mage_Edm_Helper_Media extends Mage_Core_Helper_Abstract {
	public function getPathPrefix() {
		return Mage :: getBaseDir('media') . DS . 'edm' . DS . 'company' . DS . Mage :: registry('current_company')->getId() . DS;
	}
	public function getUrlPrefix() {
		return 'edm/company/' . Mage :: registry('current_company')->getId() . '/';
	}

	public function getLayoutFileDir() {
		return Mage :: getBaseDir('media') . DS . 'edm' . DS . 'design' .DS . 'file' .DS;
	}
	public function getLayoutImageDir() {
		return Mage :: getBaseDir('media') . DS . 'edm' . DS . 'design' .DS . 'image' .DS;
	}
}
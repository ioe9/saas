<?php
class Mage_Admin_Helper_Media extends Mage_Core_Helper_Abstract
{
	protected $_dirPath = 'companys';
	protected $_documentPath = 'document';
    public function getCompanyDocumentRoot($companyId = null)
    {
    	if (!$companyId) {
    		$companyId = Mage::registry('current_company')->getId();
    	}
        return Mage::getBaseDir('media').DS.$this->_dirPath.DS.$this->_documentPath.DS;
    }
}

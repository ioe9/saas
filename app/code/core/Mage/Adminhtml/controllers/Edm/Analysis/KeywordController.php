<?php
class Mage_Adminhtml_Edm_Analysis_KeywordController extends Mage_Adminhtml_Controller_Edm
{
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('email');
		Mage::helper('edm/company_init')->initDefaultTemplate(Mage::registry('current_company'));
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_analysis_keyword', 'analysis.keyword'));
		$this->renderLayout();
	}
    protected function _isAllowed()
    {
        return true;
    }
}

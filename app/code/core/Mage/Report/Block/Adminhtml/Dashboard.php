<?php
class Mage_Report_Block_Adminhtml_Dashboard extends Mage_Adminhtml_Block_Template
{
	protected $_pageSize = 20;
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('report/dashboard.phtml');
    }
    
    protected function _prepareLayout(){
        parent::_prepareLayout();
    }
    
    public function getSubmitToHtml() {
    	return $this->getLayout()->createBlock('report/adminhtml_report_grid')->toHtml();
    }
}

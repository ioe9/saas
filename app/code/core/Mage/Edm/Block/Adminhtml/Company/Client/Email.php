<?php
class Mage_Edm_Block_Adminhtml_Company_Client_Email extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_company_client_email';
    	$this->_blockGroup = 'edm';
		$this->_headerText = "客户邮件管理";
        parent::__construct();
        
        
    }
}

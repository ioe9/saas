<?php
class Mage_Edm_Block_Adminhtml_Company_Client_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
       $this->_controller = 'adminhtml_company_client_category';
        $this->_headerText = "客户分组管理";
        $this->_blockGroup = 'edm';
        $this->_addButtonLabel = "新增客户分组";
        parent::__construct();
    }

}

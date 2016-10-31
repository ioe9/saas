<?php
class Mage_Edm_Block_Adminhtml_Company_Client_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	
    public function __construct()
    {
        $this->_objectId   = 'category_id';
        $this->_controller = 'adminhtml_company_client_category';
		$this->_mode = 'edit';
        
        parent::__construct();
       

    }
    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_category')->getId()) {
            return "编辑客户分组:".$this->escapeHtml(Mage::registry('current_category')->getName());
        }
        else {
            return '新建客户分组';
        }
    }

}
<?php
class Mage_Edm_Model_Resource_Company_Template_Module_Link extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/company_template_module_link', 'link_id');
    }
}

<?php
class Mage_Edm_Model_Resource_Templates_Module extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/templates_module', 'module_id');
    }
}

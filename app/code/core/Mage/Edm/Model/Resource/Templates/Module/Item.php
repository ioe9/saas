<?php
class Mage_Edm_Model_Resource_Templates_Module_Item extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/templates_module_item', 'item_id');
    }
}

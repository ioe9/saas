<?php
class Mage_Supplier_Model_Resource_Supplier_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("supplier/supplier");
    }
}

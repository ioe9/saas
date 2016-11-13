<?php
class Mage_Approve_Model_Resource_Apply_Audit_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("approve/apply_audit");
    }
}

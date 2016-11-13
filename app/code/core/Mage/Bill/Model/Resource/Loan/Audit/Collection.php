<?php
class Mage_Bill_Model_Resource_Loan_Audit_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("bill/loan_audit");
    }
}

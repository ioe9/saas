<?php
class Mage_Bulletin_Model_Resource_Msg_Audit_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("bulletin/msg_audit");
    }
}

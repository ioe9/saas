<?php
class Mage_Edm_Model_Resource_Banned_Emails_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/banned_emails');
    }
}

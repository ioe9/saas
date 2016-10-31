<?php
class Mage_Edm_Model_Resource_Email_White extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/email_white', 'white_id');
    }
}

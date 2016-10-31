<?php
class Mage_Edm_Model_Resource_Email_Validate extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/email_validate', 'validate_id');
    }
}

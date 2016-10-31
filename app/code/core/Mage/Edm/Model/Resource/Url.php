<?php
class Mage_Edm_Model_Resource_Url extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/url', 'url_id');
    }



}

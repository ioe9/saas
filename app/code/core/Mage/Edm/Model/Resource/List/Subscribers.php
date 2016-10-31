<?php
class Mage_Edm_Model_Resource_List_Subscribers extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/list_subscribers', 'subscriberid');
    }



}



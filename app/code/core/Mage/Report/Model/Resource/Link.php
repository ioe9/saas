<?php
class Mage_Report_Model_Resource_Link extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('report/link', 'link_id');
    }
}

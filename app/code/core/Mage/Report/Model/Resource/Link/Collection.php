<?php
class Mage_Report_Model_Resource_Link_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('report/link');
    }
}

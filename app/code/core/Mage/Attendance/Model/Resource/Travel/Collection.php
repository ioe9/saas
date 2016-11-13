<?php
class Mage_Attendance_Model_Resource_Travel_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("attendance/travel");
    }
}

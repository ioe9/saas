<?php
class Mage_Project_Model_Resource_Stage_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("project/stage");
    }
}

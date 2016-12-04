<?php
class Mage_Express_Model_Resource_Express_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("express/express");
    }
}

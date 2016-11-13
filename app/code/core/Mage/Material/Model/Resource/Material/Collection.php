<?php
class Mage_Material_Model_Resource_Material_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("material/material");
    }
}

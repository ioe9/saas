<?php
class Mage_Bill_Model_Resource_Reimburse_Item_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("bill/reimburse_item");
    }
}

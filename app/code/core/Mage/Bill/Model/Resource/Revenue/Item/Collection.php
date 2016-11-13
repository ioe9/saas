<?php
class Mage_Bill_Model_Resource_Revenue_Item_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("bill/revenue_item");
    }
}

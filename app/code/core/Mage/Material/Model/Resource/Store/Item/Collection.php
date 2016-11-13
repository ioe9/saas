<?php
class Mage_Material_Model_Resource_Store_Item_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("material/store_item");
    }
}

<?php
class Mage_Document_Model_Resource_Wish_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("document/wish");
    }
}

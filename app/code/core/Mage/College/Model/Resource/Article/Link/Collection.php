<?php
class Mage_College_Model_Resource_Article_Link_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init("college/article_link");
    }
}

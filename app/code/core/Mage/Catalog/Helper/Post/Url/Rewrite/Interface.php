<?php
interface Mage_Catalog_Helper_Post_Url_Rewrite_Interface
{
    public function getTableSelect(array $postIds, $categoryId);
    public function joinTableToSelect(Varien_Db_Select $select);
}

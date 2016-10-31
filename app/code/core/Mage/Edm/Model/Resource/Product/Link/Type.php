<?php
class Mage_Edm_Model_Resource_Product_Link_Type extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/product_link_type', 'type_id');
    }

}

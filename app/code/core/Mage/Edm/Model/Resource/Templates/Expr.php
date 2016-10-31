<?php
class Mage_Edm_Model_Resource_Templates_Expr extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/templates_expr', 'expr_id');
    }
}

<?php
/**
 * Resource model for manipulate system variables
 *
 * @category   Mage
 * @package    Mage_Admin
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Admin_Model_Resource_Variable extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('admin/permission_variable', 'variable_id');
    }
}

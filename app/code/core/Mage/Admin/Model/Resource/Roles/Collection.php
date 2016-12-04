<?php
/**
 * Admin roles collection
 *
 * @category    Mage
 * @package     Mage_Admin
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Admin_Model_Resource_Roles_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('admin/role');
    }

    /**
     * Init select
     *
     * @return Mage_Admin_Model_Resource_Roles_Collection
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()->where("main_table.role_type = ?", 'G');

        return $this;
    }

    /**
     * Convert to option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('role_id', 'role_name');
    }
}

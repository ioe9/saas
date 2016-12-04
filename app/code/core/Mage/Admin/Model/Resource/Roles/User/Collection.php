<?php
/**
 * Admin role users collection
 *
 * @category    Mage
 * @package     Mage_Admin
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Admin_Model_Resource_Roles_User_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('admin/user');
    }

    /**
     * Initialize select
     *
     * @return Mage_Admin_Model_Resource_Roles_User_Collection
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()->where("user_id > 0");

        return $this;
    }
}

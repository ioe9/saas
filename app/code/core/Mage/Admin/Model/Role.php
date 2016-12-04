<?php
/**
 * Admin Role Model
 *
 * @method Mage_Admin_Model_Resource_Role _getResource()
 * @method Mage_Admin_Model_Resource_Role getResource()
 * @method int getParentId()
 * @method Mage_Admin_Model_Role setParentId(int $value)
 * @method int getTreeLevel()
 * @method Mage_Admin_Model_Role setTreeLevel(int $value)
 * @method int getSortOrder()
 * @method Mage_Admin_Model_Role setSortOrder(int $value)
 * @method string getRoleType()
 * @method Mage_Admin_Model_Role setRoleType(string $value)
 * @method int getUserId()
 * @method Mage_Admin_Model_Role setUserId(int $value)
 * @method string getRoleName()
 * @method Mage_Admin_Model_Role setRoleName(string $value)
 *
 * @category    Mage
 * @package     Mage_Admin
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Admin_Model_Role extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('admin/role');
    }
}

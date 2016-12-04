<?php
/**
 * Rules collection
 *
 * @category    Mage
 * @package     Mage_Admin
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Admin_Model_Resource_Rules_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('admin/rules');
    }

    /**
     * Get rules by role id
     *
     * @param int $id
     * @return Mage_Admin_Model_Resource_Rules_Collection
     */
    public function getByRoles($id)
    {
        $this->addFieldToFilter('role_id', (int) $id);
        return $this;
    }

    /**
     * Sort by length
     *
     * @return Mage_Admin_Model_Resource_Rules_Collection
     */
    public function addSortByLength()
    {
        $length = $this->getConnection()->getLengthSql('{{resource_id}}');
        $this->addExpressionFieldToSelect('length', $length, 'resource_id');
        $this->getSelect()->order('length ' . Varien_Db_Select::SQL_DESC);

        return $this;
    }

    /**
     * Generate and retrieve a resource - permissions map
     * @return array
     */
    public function getResourcesPermissionsArray()
    {
        $resourcesPermissionsArray = array();
        foreach ($this as $item) {
            $resourcesPermissionsArray[$item->getResourceId()] = $item->getPermission();
        }

        return $resourcesPermissionsArray;
    }
}

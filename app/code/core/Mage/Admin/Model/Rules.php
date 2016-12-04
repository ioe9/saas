<?php
/**
 * Admin Rules Model
 *
 * @method Mage_Admin_Model_Resource_Rules _getResource()
 * @method Mage_Admin_Model_Resource_Rules getResource()
 * @method int getRoleId()
 * @method Mage_Admin_Model_Rules setRoleId(int $value)
 * @method string getResourceId()
 * @method Mage_Admin_Model_Rules setResourceId(string $value)
 * @method string getPrivileges()
 * @method Mage_Admin_Model_Rules setPrivileges(string $value)
 * @method int getAssertId()
 * @method Mage_Admin_Model_Rules setAssertId(int $value)
 * @method string getRoleType()
 * @method Mage_Admin_Model_Rules setRoleType(string $value)
 * @method string getPermission()
 * @method Mage_Admin_Model_Rules setPermission(string $value)
 *
 * @category    Mage
 * @package     Mage_Admin
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Admin_Model_Rules extends Mage_Core_Model_Abstract
{
    /**
     * Allowed permission code
     */
    const RULE_PERMISSION_ALLOWED = 'allow';

    /**
     * Denied permission code
     */
    const RULE_PERMISSION_DENIED = 'deny';

    protected function _construct()
    {
        $this->_init('admin/rules');
    }

    /**
     * Update rules
     * @return $this
     */
    public function update()
    {
        $this->getResource()->update($this);
        return $this;
    }

    /**
     * Initialize and retrieve permissions collection
     * @return Object
     */
    public function getCollection()
    {
        return Mage::getResourceModel('admin/permissions_collection');
    }

    /**
     * Save rules relations to the database
     * @return $this
     */
    public function saveRel()
    {
        $this->getResource()->saveRel($this);
        return $this;
    }

    /**
     * Check if the current rule is allowed
     * @return bool
     */
    public function isAllowed()
    {
        return $this->getPermission() == self::RULE_PERMISSION_ALLOWED;
    }

    /**
     * Check if the current rule is denied
     */
    public function isDenied()
    {
        return $this->getPermission() == self::RULE_PERMISSION_DENIED;
    }
}

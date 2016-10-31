<?php
class Mage_Admin_Model_Acl extends Varien_Acl
{
    /**
     * All the group roles are prepended by G
     *
     */
    const ROLE_TYPE_GROUP = 'G';
    
    /**
     * All the user roles are prepended by U
     *
     */
    const ROLE_TYPE_USER = 'U';
    
    /**
     * Permission level to deny access
     *
     */
    const RULE_PERM_DENY = 0;
    
    /**
     * Permission level to inheric access from parent role
     *
     */
    const RULE_PERM_INHERIT = 1;
    
    /**
     * Permission level to allow access
     *
     */
    const RULE_PERM_ALLOW = 2;
    
    /**
     * Get role registry object or create one
     *
     * @return Mage_Admin_Model_Acl_Role_Registry
     */
    protected function _getRoleRegistry()
    {
        if (null === $this->_roleRegistry) {
            $this->_roleRegistry = Mage::getModel('admin/acl_role_registry');
        }
        return $this->_roleRegistry;
    }
    
    /**
     * Add parent to role object
     *
     * @param Zend_Acl_Role $role
     * @param Zend_Acl_Role $parent
     * @return Mage_Admin_Model_Acl
     */
    public function addRoleParent($role, $parent)
    {
        $this->_getRoleRegistry()->addParent($role, $parent);
        return $this;
    }
}

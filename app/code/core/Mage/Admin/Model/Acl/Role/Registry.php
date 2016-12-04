<?php
/**
 * Acl role registry
 * 
 * @category   Mage
 * @package    Mage_Admin
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Admin_Model_Acl_Role_Registry extends Varien_Acl_Role_Registry 
{
    /**
     * Add parent to the $role node
     *
     * @param Varien_Acl_Role_Interface|string $role
     * @param array|Varien_Acl_Role_Interface|string $parents
     * @return Mage_Auth_Model_Acl_Role_Registry
     */
    function addParent($role, $parents)
    {
        try {
            if ($role instanceof Varien_Acl_Role_Interface) {
                $roleId = $role->getRoleId();
            } else {
                $roleId = $role;
                $role = $this->get($role);
            }
        } catch (Varien_Acl_Role_Registry_Exception $e) {
            throw new Varien_Acl_Role_Registry_Exception("Child Role id '$roleId' does not exist");
        }
        
        if (!is_array($parents)) {
            $parents = array($parents);
        }
        foreach ($parents as $parent) {
            try {
                if ($parent instanceof Varien_Acl_Role_Interface) {
                    $roleParentId = $parent->getRoleId();
                } else {
                    $roleParentId = $parent;
                }
                $roleParent = $this->get($roleParentId);
            } catch (Varien_Acl_Role_Registry_Exception $e) {
                throw new Varien_Acl_Role_Registry_Exception("Parent Role id '$roleParentId' does not exist");
            }
            $this->_roles[$roleId]['parents'][$roleParentId] = $roleParent;
            $this->_roles[$roleParentId]['children'][$roleId] = $role;
        }
        return $this;
    }
}

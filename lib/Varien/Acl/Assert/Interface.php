<?php
interface Varien_Acl_Assert_Interface
{
    /**
     * Returns true if and only if the assertion conditions are met
     *
     * This method is passed the ACL, Role, Resource, and privilege to which the authorization query applies. If the
     * $role, $resource, or $privilege parameters are null, it means that the query applies to all Roles, Resources, or
     * privileges, respectively.
     *
     * @param  Varien_Acl                    $acl
     * @param  Varien_Acl_Role_Interface     $role
     * @param  Varien_Acl_Resource_Interface $resource
     * @param  string                      $privilege
     * @return boolean
     */
    public function assert(Varien_Acl $acl, Varien_Acl_Role_Interface $role = null, Varien_Acl_Resource_Interface $resource = null,
                           $privilege = null);
}

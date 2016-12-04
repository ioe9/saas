<?php
/**
 * Assert time for admin acl
 * 
 * @category   Mage
 * @package    Mage_Admin
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Admin_Model_Acl_Assert_Time implements Varien_Acl_Assert_Interface 
{
    /**
     * Assert time
     *
     * @param Varien_Acl $acl
     * @param Varien_Acl_Role_Interface $role
     * @param Varien_Acl_Resource_Interface $resource
     * @param string $privilege
     * @return boolean
     */
    public function assert(Mage_Admin_Model_Acl $acl, Mage_Admin_Model_Acl_Role $role = null,
                           Mage_Admin_Model_Acl_Resource $resource = null, $privilege = null)
    {
        return $this->_isCleanTime(time());
    }

    protected function _isCleanTime($time)
    {
        // ...
    }
}

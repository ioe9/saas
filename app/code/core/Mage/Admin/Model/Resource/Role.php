<?php
/**
 * Admin role resource model
 *
 * @category    Mage
 * @package     Mage_Admin
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Admin_Model_Resource_Role extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Define main table
     *
     */
    protected function _construct()
    {
        $this->_init('admin/role', 'role_id');
    }

    /**
     * Process role before saving
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Admin_Model_Resource_Role
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if ( !$object->getId() ) {
            $object->setCreated($this->formatDate(true));
        }
        $object->setModified($this->formatDate(true));
        return $this;
    }
}

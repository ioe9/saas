<?php
/**
 * Admin rule resource model
 *
 * @category    Mage
 * @package     Mage_Admin
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Admin_Model_Resource_Rules extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Define main table
     *
     */
    protected function _construct()
    {
        $this->_init('admin/rule', 'rule_id');
    }

    /**
     * Save ACL resources
     *
     * @param Mage_Admin_Model_Rules $rule
     */
    public function saveRel(Mage_Admin_Model_Rules $rule)
    {
        try {
            $adapter = $this->_getWriteAdapter();
            $adapter->beginTransaction();
            $roleId = $rule->getRoleId();

            $condition = array(
                'role_id = ?' => (int) $roleId,
            );

            $adapter->delete($this->getMainTable(), $condition);

            $postedResources = $rule->getResources();
            if ($postedResources) {
                $row = array(
                    'role_type'   => 'G',
                    'resource_id' => 'all',
                    'privileges'  => '', // not used yet
                    'assert_id'   => 0,
                    'role_id'     => $roleId,
                    'permission'  => 'allow'
                );

                // If all was selected save it only and nothing else.
                if ($postedResources === array('all')) {
                    $insertData = $this->_prepareDataForTable(new Varien_Object($row), $this->getMainTable());

                    $adapter->insert($this->getMainTable(), $insertData);
                } else {
                    foreach (Mage::getModel('admin/roles')->getResourcesList2D() as $index => $resName) {
                        $row['permission']  = (in_array($resName, $postedResources) ? 'allow' : 'deny');
                        $row['resource_id'] = trim($resName, '/');

                        $insertData = $this->_prepareDataForTable(new Varien_Object($row), $this->getMainTable());
                        $adapter->insert($this->getMainTable(), $insertData);
                    }
                }
            }

            $adapter->commit();
        } catch (Mage_Core_Exception $e) {
            $adapter->rollBack();
            throw $e;
        } catch (Exception $e){
            $adapter->rollBack();
            Mage::logException($e);
        }
    }
}

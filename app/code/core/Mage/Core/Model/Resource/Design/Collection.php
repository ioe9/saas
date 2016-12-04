<?php
/**
 * Core Design resource collection
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Model_Resource_Design_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Core Design resource collection
     *
     */
    protected function _construct()
    {
        $this->_init('core/design');
    }

    /**
     * Join store data to collection
     *
     * @return Mage_Core_Model_Resource_Design_Collection
     */
    public function joinStore()
    {
         return $this->join(
            array('cs' => 'core/store'),
            'cs.store_id = main_table.store_id',
            array('cs.name'));
    }

    /**
     * Add date filter to collection
     *
     * @param null|int|string|Zend_Date $date
     * @return Mage_Core_Model_Resource_Design_Collection
     */
    public function addDateFilter($date = null)
    {
        if (is_null($date)) {
            $date = $this->formatDate(true);
        } else {
            $date = $this->formatDate($date);
        }

        $this->addFieldToFilter('date_from', array('lteq' => $date));
        $this->addFieldToFilter('date_to', array('gteq' => $date));
        return $this;
    }

    /**
     * Add store filter to collection
     *
     * @param int|array $storeId
     * @return Mage_Core_Model_Resource_Design_Collection
     */
    public function addStoreFilter($storeId)
    {
        return $this->addFieldToFilter('store_id', array('in' => $storeId));
    }
}

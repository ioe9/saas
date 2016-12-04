<?php
/**
 * Queue resource collection
 *
 * @category   Mage
 * @package    Mage_Core
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Model_Resource_Email_Queue_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Internal constructor
     *
     * @return null
     */
    protected function _construct()
    {
        $this->_init('core/email_queue');
    }

    /**
     * Add recipients and unserialize message parameters
     *
     * @return Mage_Core_Model_Resource_Email_Queue_Collection
     */
    protected function _afterLoad()
    {
        $this->walk('afterLoad');
        return $this;
    }

    /**
     * Add filter by only ready for sending item
     *
     * @return Mage_Core_Model_Resource_Email_Queue_Collection
     */
    public function addOnlyForSendingFilter()
    {
        $this->getSelect()->where('main_table.processed_at IS NULL');
        return $this;
    }
}

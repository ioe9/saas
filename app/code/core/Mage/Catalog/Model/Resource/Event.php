<?php
class Mage_Catalog_Model_Resource_Event extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Event to category linkage table
     *
     * @var string
     */
    protected $_eventCategoryTable;


	protected function _construct()
    {
        $this->_init('catalog/event', 'event_id');
        $this->_eventCategoryTable = $this->getTable('catalog/category_event');
    }

    /**
     * Retrieve event category identifiers
     *
     * @param Mage_Catalog_Model_Event $event
     * @return array
     */
    public function getCategoryIds($event)
    {
        $adapter = $this->_getReadAdapter();

        $select = $adapter->select()
            ->from($this->_eventCategoryTable, 'category_id')
            ->where('event_id = ?', (int)$event->getId());
		$res = $adapter->fetchCol($select);
		
        return $res;
    }

    /**
     * Process event data before save
     *
     * @param Varien_Object $object
     * @return Mage_Catalog_Model_Resource_Event
     */
    protected function _beforeSave(Varien_Object $object)
    {	
        /**
         * Check if declared category ids in object data.
         */
        if ($object->hasCategoryIds()) {
            $categoryIds = Mage::getResourceSingleton('catalog/category')->verifyIds(
                $object->getCategoryIds()
            );
            $object->setCategoryIds($categoryIds);
        }

        return parent::_beforeSave($object);
    }

    /**
     * Save data related with event
     *
     * @param Varien_Object $event
     * @return Mage_Catalog_Model_Resource_Event
     */
    protected function _afterSave(Varien_Object $event)
    {
        $this->_saveCategories($event);
        return parent::_afterSave($event);
    }

    /**
     * Save event category relations
     *
     * @param Varien_Object $object
     * @return Mage_Catalog_Model_Resource_Event
     */
    protected function _saveCategories(Varien_Object $object)
    {
        /**
         * If category ids data is not declared we haven't do manipulations
         */
        if (!$object->hasCategoryIds()) {
            return $this;
        }
        $categoryIds = $object->getCategoryIds();
        $oldCategoryIds = $this->getCategoryIds($object);

        $object->setIsChangedCategories(false);

        $insert = array_diff($categoryIds, $oldCategoryIds);
        $delete = array_diff($oldCategoryIds, $categoryIds);

        $write = $this->_getWriteAdapter();
        if (!empty($insert)) {
            $data = array();
            foreach ($insert as $categoryId) {
                if (empty($categoryId)) {
                    continue;
                }
                $data[] = array(
                    'category_id' => (int)$categoryId,
                    'event_id'  => (int)$object->getId(),
                    'position'    => 1
                );
            }
            if ($data) {
                $write->insertMultiple($this->_eventCategoryTable, $data);
            }
        }

        if (!empty($delete)) {
            foreach ($delete as $categoryId) {
                $where = array(
                    'event_id = ?'  => (int)$object->getId(),
                    'category_id = ?' => (int)$categoryId,
                );

                $write->delete($this->_eventCategoryTable, $where);
            }
        }

        if (!empty($insert) || !empty($delete)) {
            $object->setAffectedCategoryIds(array_merge($insert, $delete));
            $object->setIsChangedCategories(true);
        }

        return $this;
    }
    /**
     * Get collection of event categories
     *
     * @param Mage_Catalog_Model_Event $event
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function getCategoryCollection($event)
    {
        $collection = Mage::getResourceModel('catalog/category_collection')
            ->joinField('event_id',
                'catalog/category_event',
                'event_id',
                'category_id = category_id',
                null)
            ->addFieldToFilter('event_id', (int)$event->getId());
        return $collection;
    }
    public function validate($obj) {
    	return true;
    }
}

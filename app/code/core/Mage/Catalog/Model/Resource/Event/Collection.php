<?php
class Mage_Catalog_Model_Resource_Event_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Event categories table name
     *
     * @var string
     */
    protected $_eventCategoryTable;

    /**
     * Is add URL rewrites to collection flag
     *
     * @var bool
     */
    protected $_addUrlRewrite                = false;

    /**
     * Add URL rewrite for category
     *
     * @var int
     */
    protected $_urlRewriteCategory           = '';

    /**
     * Cache for all ids
     *
     * @var array
     */
    protected $_allIdsCache                  = null;

    protected $_eventLimitationFilters     = array();

    /**
     * Category event count select
     *
     * @var Varien_Db_Select
     */
    protected $_eventCountSelect           = null;


    /**
     * Get cloned Select after dispatching 'catalog_prepare_price_select' event
     *
     * @return Varien_Db_Select
     */
    public function getCatalogPreparedSelect()
    {
        return $this->_catalogPreparePriceSelect;
    }

    /**
     * Initialize resources
     *
     */
    protected function _construct()
    {
        
        $this->_init('catalog/event');

        $this->_initTables();
    }

    /**
     * Define category event tables
     *
     */
    protected function _initTables()
    {
        $this->_eventCategoryTable= $this->getResource()->getTable('catalog/category_event');
    }

    /**
     * Add tax class id attribute to select and join price rules data if needed
     *
     * @return Mage_Catalog_Model_Resource_Event_Collection
     */
    protected function _beforeLoad()
    {
        Mage::dispatchEvent('catalog_event_collection_load_before', array('collection' => $this));

        return parent::_beforeLoad();
    }

    /**
     * Processing collection items after loading
     * Adding url rewrites, minimal prices, final prices, tax percents
     *
     * @return Mage_Catalog_Model_Resource_Event_Collection
     */
    protected function _afterLoad()
    {
        if ($this->_addUrlRewrite) {
           $this->_addUrlRewrite($this->_urlRewriteCategory);
        }

        if (count($this) > 0) {
            Mage::dispatchEvent('catalog_event_collection_load_after', array('collection' => $this));
        }
        return $this;
    }

    /**
     * Prepare Url Data object
     *
     * @return Mage_Catalog_Model_Resource_Event_Collection
     * @deprecated after 1.7.0.2
     */
    protected function _prepareUrlDataObject()
    {
        $objects = array();
        /** @var $item Mage_Catalog_Model_Event */
        foreach ($this->_items as $item) {
            if ($this->getFlag('do_not_use_category_id')) {
                $item->setDoNotUseCategoryId(true);
            }

        }

        if ($objects && $this->hasFlag('url_data_object')) {
            $objects = Mage::getResourceSingleton('catalog/url')
                ->getRewriteByEventStore($objects);
           
        }

        return $this;
    }

    /**
     * Add collection filters by identifiers
     *
     * @param mixed $eventId
     * @param boolean $exclude
     * @return Mage_Catalog_Model_Resource_Event_Collection
     */
    public function addIdFilter($eventId, $exclude = false)
    {
        if (empty($eventId)) {
            $this->_setIsLoaded(true);
            return $this;
        }
        if (is_array($eventId)) {
            if (!empty($eventId)) {
                if ($exclude) {
                    $condition = array('nin' => $eventId);
                } else {
                    $condition = array('in' => $eventId);
                }
            } else {
                $condition = '';
            }
        } else {
            if ($exclude) {
                $condition = array('neq' => $eventId);
            } else {
                $condition = $eventId;
            }
        }
        $this->addFieldToFilter('event_id', $condition);
        return $this;
    }
    /**
     * Get filters applied to collection
     *
     * @return array
     */
    public function getLimitationFilters()
    {
        return $this->_eventLimitationFilters;
    }

    /**
     * Specify category filter for event collection
     *
     * @param Mage_Catalog_Model_Category $category
     * @return Mage_Catalog_Model_Resource_Event_Collection
     */
    public function addCategoryFilter(Mage_Catalog_Model_Category $category)
    {
        $this->_eventLimitationFilters['category_id'] = $category->getId();
        if ($category->getIsAnchor()) {
            unset($this->_eventLimitationFilters['category_is_anchor']);
        } else {
            $this->_eventLimitationFilters['category_is_anchor'] = 1;
        }


        $this->_applyEventLimitations();
        

        return $this;
    }
    /**
     * Get SQL for get record count without left JOINs
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        return $this->_getSelectCountSql();
    }

    /**
     * Get SQL for get record count
     *
     * @param bool $resetLeftJoins
     * @return Varien_Db_Select
     */
    protected function _getSelectCountSql($select = null, $resetLeftJoins = true)
    {
        $this->_renderFilters();
        $countSelect = (is_null($select)) ?
            $this->_getClearSelect() :
            $this->_buildClearSelect($select);
        // Clear GROUP condition for count method
        $countSelect->reset(Varien_Db_Select::GROUP);
        $countSelect->columns('COUNT(DISTINCT main_table.event_id)');
        if ($resetLeftJoins) {
            $countSelect->resetJoinLeft();
        }
        return $countSelect;
    }

    /**
     * Retreive clear select
     *
     * @return Varien_Db_Select
     */
    protected function _getClearSelect()
    {
        return $this->_buildClearSelect();
    }

    /**
     * Build clear select
     *
     * @param Varien_Db_Select $select
     * @return Varien_Db_Select
     */
    protected function _buildClearSelect($select = null)
    {
        if (is_null($select)) {
            $select = clone $this->getSelect();
        }
        $select->reset(Varien_Db_Select::ORDER);
        $select->reset(Varien_Db_Select::LIMIT_COUNT);
        $select->reset(Varien_Db_Select::LIMIT_OFFSET);
        $select->reset(Varien_Db_Select::COLUMNS);

        return $select;
    }

    /**
     * Retreive event count select for categories
     *
     * @return Varien_Db_Select
     */
    public function getEventCountSelect()
    {
        if ($this->_eventCountSelect === null) {
            $this->_eventCountSelect = clone $this->getSelect();
            $this->_eventCountSelect->reset(Varien_Db_Select::COLUMNS)
                ->reset(Varien_Db_Select::GROUP)
                ->reset(Varien_Db_Select::ORDER)
                ->distinct(false)
                ->join(array('count_table' => $this->getTable('catalog/category_event')),
                    'count_table.event_id = main_table.event_id',
                    array(
                        'count_table.category_id',
                        'event_count' => new Magento_Db_Expr('COUNT(DISTINCT count_table.event_id)')
                    )
                )
                ->group('count_table.category_id');
        }

        return $this->_eventCountSelect;
    }

    /**
     * Destruct event count select
     *
     * @return Mage_Catalog_Model_Resource_Event_Collection
     */
    public function unsEventCountSelect()
    {
        $this->_eventCountSelect = null;
        return $this;
    }

    /**
     * Adding event count to categories collection
     *
     * @param Mage_Eav_Model_Entity_Collection_Abstract $categoryCollection
     * @return Mage_Catalog_Model_Resource_Event_Collection
     */
    public function addCountToCategories($categoryCollection)
    {
        $isAnchor    = array();
        $isNotAnchor = array();
        foreach ($categoryCollection as $category) {
            if ($category->getIsAnchor()) {
                $isAnchor[]    = $category->getId();
            } else {
                $isNotAnchor[] = $category->getId();
            }
        }
        $eventCounts = array();
        if ($isAnchor || $isNotAnchor) {
            $select = $this->getEventCountSelect();

            Mage::dispatchEvent(
                'catalog_event_collection_before_add_count_to_categories',
                array('collection' => $this)
            );

            if ($isAnchor) {
                $anchorStmt = clone $select;
                $anchorStmt->limit(); //reset limits
                $anchorStmt->where('count_table.category_id IN (?)', $isAnchor);
                $eventCounts += $this->getConnection()->fetchPairs($anchorStmt);
                $anchorStmt = null;
            }
            if ($isNotAnchor) {
                $notAnchorStmt = clone $select;
                $notAnchorStmt->limit(); //reset limits
                $notAnchorStmt->where('count_table.category_id IN (?)', $isNotAnchor);
                $notAnchorStmt->where('count_table.is_parent = 1');
                $eventCounts += $this->getConnection()->fetchPairs($notAnchorStmt);
                $notAnchorStmt = null;
            }
            $select = null;
            $this->unsEventCountSelect();
        }

        foreach ($categoryCollection as $category) {
            $_count = 0;
            if (isset($eventCounts[$category->getId()])) {
                $_count = $eventCounts[$category->getId()];
            }
            $category->setEventCount($_count);
        }

        return $this;
    }

    /**
     * Joins url rewrite rules to collection
     *
     * @deprecated after 1.7.0.2. Method is not used anywhere in the code.
     * @return Mage_Catalog_Model_Resource_Event_Collection
     */
    public function joinUrlRewrite()
    {
        $this->joinTable(
            'core/url_rewrite',
            'event_id=event_id',
            array('request_path'),
            '{{table}}.type = ' . Mage_Core_Model_Url_Rewrite::TYPE_PRODUCT,
            'left'
        );

        return $this;
    }

    /**
     * Add URL rewrites data to event
     * If collection loadded - run processing else set flag
     *
     * @param int|string $categoryId
     * @return Mage_Catalog_Model_Resource_Event_Collection
     */
    public function addUrlRewrite($categoryId = '')
    {
        $this->_addUrlRewrite = true;
        if (Mage::getStoreConfig(Mage_Catalog_Helper_Event::XML_PATH_PRODUCT_URL_USE_CATEGORY)) {
            $this->_urlRewriteCategory = $categoryId;
        } else {
            $this->_urlRewriteCategory = 0;
        }

        if ($this->isLoaded()) {
            $this->_addUrlRewrite();
        }

        return $this;
    }

    /**
     * Add URL rewrites to collection
     *
     */
    protected function _addUrlRewrite()
    {
        $urlRewrites = null;
        if ($this->_cacheConf) {
            if (!($urlRewrites = Mage::app()->loadCache($this->_cacheConf['prefix'] . 'urlrewrite'))) {
                $urlRewrites = null;
            } else {
                $urlRewrites = unserialize($urlRewrites);
            }
        }

        if (!$urlRewrites) {
            $eventIds = array();
            foreach($this->getItems() as $item) {
                $eventIds[] = $item->getEventId();
            }
            if (!count($eventIds)) {
                return;
            }

            $select = Mage::getSingleton('catalog/factory')->getEventUrlRewriteHelper()
                ->getTableSelect($eventIds, $this->_urlRewriteCategory);

            $urlRewrites = array();
            foreach ($this->getConnection()->fetchAll($select) as $row) {
                if (!isset($urlRewrites[$row['event_id']])) {
                    $urlRewrites[$row['event_id']] = $row['request_path'];
                }
            }

            if ($this->_cacheConf) {
                Mage::app()->saveCache(
                    serialize($urlRewrites),
                    $this->_cacheConf['prefix'] . 'urlrewrite',
                    array_merge($this->_cacheConf['tags'], array(Mage_Catalog_Model_Event_Url::CACHE_TAG)),
                    $this->_cacheLifetime
                );
            }
        }

        foreach($this->getItems() as $item) {
            if (empty($this->_urlRewriteCategory)) {
                $item->setDoNotUseCategoryId(true);
            }
            if (isset($urlRewrites[$item->getEntityId()])) {
                $item->setData('request_path', $urlRewrites[$item->getEntityId()]);
            } else {
                $item->setData('request_path', false);
            }
        }
    }


    /**
     * Prepare limitation filters
     *
     * @return Mage_Catalog_Model_Resource_Event_Collection
     */
    protected function _prepareEventLimitationFilters()
    {
        if (isset($this->_eventLimitationFilters['visibility'])
            && !isset($this->_eventLimitationFilters['category_id'])
        ) {
            $this->_eventLimitationFilters['category_id'] = Mage_Catalog_Model_Category::TREE_DEFAULT_ID;
        }

        return $this;
    }

    /**
     * Apply limitation filters to collection
     * Method allows using one time category event index table (or event website table)
     * for different combinations of store_id/category_id/visibility filter states
     * Method supports multiple changes in one collection object for this parameters
     *
     * @return Mage_Catalog_Model_Resource_Event_Collection
     */
    protected function _applyEventLimitations()
    {
        Mage::dispatchEvent('catalog_event_collection_apply_limitations_before', array(
            'collection'  => $this,
            'category_id' => isset($this->_eventLimitationFilters['category_id'])
                ? $this->_eventLimitationFilters['category_id']
                : null,
        ));
        $this->_prepareEventLimitationFilters();
        $filters = $this->_eventLimitationFilters;

        if (!isset($filters['category_id']) && !isset($filters['visibility'])) {
            return $this;
        }

        $conditions = array(
            'cat_index.event_id=main_table.event_id',
            $this->getConnection()->quoteInto('cat_index.store_id=?', $filters['store_id'])
        );
        if (isset($filters['visibility']) && !isset($filters['store_table'])) {
            $conditions[] = $this->getConnection()
                ->quoteInto('cat_index.visibility IN(?)', $filters['visibility']);
        }

        if (!$this->getFlag('disable_root_category_filter')) {
            $conditions[] = $this->getConnection()->quoteInto('cat_index.category_id = ?', $filters['category_id']);
        }

        if (isset($filters['category_is_anchor'])) {
            $conditions[] = $this->getConnection()
                ->quoteInto('cat_index.is_parent=?', $filters['category_is_anchor']);
        }
        Mage::dispatchEvent('catalog_event_collection_apply_limitations_after', array(
            'collection' => $this
        ));

        return $this;
    }


    /**
     * Add category ids to loaded items
     *
     * @return Mage_Catalog_Model_Resource_Event_Collection
     */
    public function addCategoryIds()
    {
        if ($this->getFlag('category_ids_added')) {
            return $this;
        }
        $ids = array_keys($this->_items);
        if (empty($ids)) {
            return $this;
        }

        $select = $this->getConnection()->select();

        $select->from($this->_eventCategoryTable, array('event_id', 'category_id'));
        $select->where('event_id IN (?)', $ids);

        $data = $this->getConnection()->fetchAll($select);

        $categoryIds = array();
        foreach ($data as $info) {
            if (isset($categoryIds[$info['event_id']])) {
                $categoryIds[$info['event_id']][] = $info['category_id'];
            } else {
                $categoryIds[$info['event_id']] = array($info['category_id']);
            }
        }


        foreach ($this->getItems() as $item) {
            $eventId = $item->getId();
            if (isset($categoryIds[$eventId])) {
                $item->setCategoryIds($categoryIds[$eventId]);
            } else {
                $item->setCategoryIds(array());
            }
        }

        $this->setFlag('category_ids_added', true);
        return $this;
    }

    /**
     * Clear collection
     *
     * @return Mage_Catalog_Model_Resource_Event_Collection
     */
    public function clear()
    {
        foreach ($this->_items as $i => $item) {
            if ($item->hasStockItem()) {
                $item->unsStockItem();
            }
            $item = $this->_items[$i] = null;
        }

        foreach ($this->_itemsById as $i => $item) {
            $item = $this->_itemsById[$i] = null;
        }

        unset($this->_items, $this->_data, $this->_itemsById);
        $this->_data = array();
        $this->_itemsById = array();
        return parent::clear();
    }
}

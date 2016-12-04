<?php
class Mage_Catalog_Model_Resource_Post_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Post categories table name
     *
     * @var string
     */
    protected $_postCategoryTable;

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

    protected $_postLimitationFilters     = array();

    /**
     * Category post count select
     *
     * @var Varien_Db_Select
     */
    protected $_postCountSelect           = null;


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
        
        $this->_init('catalog/post');

        $this->_initTables();
    }

    /**
     * Define category post tables
     *
     */
    protected function _initTables()
    {
        $this->_postCategoryTable= $this->getResource()->getTable('catalog/category_post');
    }

    /**
     * Add tax class id attribute to select and join price rules data if needed
     *
     * @return Mage_Catalog_Model_Resource_Post_Collection
     */
    protected function _beforeLoad()
    {
        Mage::dispatchEvent('catalog_post_collection_load_before', array('collection' => $this));

        return parent::_beforeLoad();
    }

    /**
     * Processing collection items after loading
     * Adding url rewrites, minimal prices, final prices, tax percents
     *
     * @return Mage_Catalog_Model_Resource_Post_Collection
     */
    protected function _afterLoad()
    {
        if ($this->_addUrlRewrite) {
           $this->_addUrlRewrite($this->_urlRewriteCategory);
        }

        if (count($this) > 0) {
            Mage::dispatchEvent('catalog_post_collection_load_after', array('collection' => $this));
        }
        return $this;
    }

    /**
     * Prepare Url Data object
     *
     * @return Mage_Catalog_Model_Resource_Post_Collection
     * @deprecated after 1.7.0.2
     */
    protected function _prepareUrlDataObject()
    {
        $objects = array();
        /** @var $item Mage_Catalog_Model_Post */
        foreach ($this->_items as $item) {
            if ($this->getFlag('do_not_use_category_id')) {
                $item->setDoNotUseCategoryId(true);
            }

        }

        if ($objects && $this->hasFlag('url_data_object')) {
            $objects = Mage::getResourceSingleton('catalog/url')
                ->getRewriteByPostStore($objects);
           
        }

        return $this;
    }

    /**
     * Add collection filters by identifiers
     *
     * @param mixed $postId
     * @param boolean $exclude
     * @return Mage_Catalog_Model_Resource_Post_Collection
     */
    public function addIdFilter($postId, $exclude = false)
    {
        if (empty($postId)) {
            $this->_setIsLoaded(true);
            return $this;
        }
        if (is_array($postId)) {
            if (!empty($postId)) {
                if ($exclude) {
                    $condition = array('nin' => $postId);
                } else {
                    $condition = array('in' => $postId);
                }
            } else {
                $condition = '';
            }
        } else {
            if ($exclude) {
                $condition = array('neq' => $postId);
            } else {
                $condition = $postId;
            }
        }
        $this->addFieldToFilter('post_id', $condition);
        return $this;
    }
    /**
     * Get filters applied to collection
     *
     * @return array
     */
    public function getLimitationFilters()
    {
        return $this->_postLimitationFilters;
    }

    /**
     * Specify category filter for post collection
     *
     * @param Mage_Catalog_Model_Category $category
     * @return Mage_Catalog_Model_Resource_Post_Collection
     */
    public function addCategoryFilter(Mage_Catalog_Model_Category $category)
    {
        $this->_postLimitationFilters['category_id'] = $category->getId();
        if ($category->getIsAnchor()) {
            unset($this->_postLimitationFilters['category_is_anchor']);
        } else {
            $this->_postLimitationFilters['category_is_anchor'] = 1;
        }


        $this->_applyPostLimitations();
        

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
        $countSelect->columns('COUNT(DISTINCT main_table.post_id)');
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
     * Retreive post count select for categories
     *
     * @return Varien_Db_Select
     */
    public function getPostCountSelect()
    {
        if ($this->_postCountSelect === null) {
            $this->_postCountSelect = clone $this->getSelect();
            $this->_postCountSelect->reset(Varien_Db_Select::COLUMNS)
                ->reset(Varien_Db_Select::GROUP)
                ->reset(Varien_Db_Select::ORDER)
                ->distinct(false)
                ->join(array('count_table' => $this->getTable('catalog/category_post')),
                    'count_table.post_id = main_table.post_id',
                    array(
                        'count_table.category_id',
                        'post_count' => new Magento_Db_Expr('COUNT(DISTINCT count_table.post_id)')
                    )
                )
                ->group('count_table.category_id');
        }

        return $this->_postCountSelect;
    }

    /**
     * Destruct post count select
     *
     * @return Mage_Catalog_Model_Resource_Post_Collection
     */
    public function unsPostCountSelect()
    {
        $this->_postCountSelect = null;
        return $this;
    }

    /**
     * Adding post count to categories collection
     *
     * @param Mage_Eav_Model_Entity_Collection_Abstract $categoryCollection
     * @return Mage_Catalog_Model_Resource_Post_Collection
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
        $postCounts = array();
        if ($isAnchor || $isNotAnchor) {
            $select = $this->getPostCountSelect();

            Mage::dispatchEvent(
                'catalog_post_collection_before_add_count_to_categories',
                array('collection' => $this)
            );

            if ($isAnchor) {
                $anchorStmt = clone $select;
                $anchorStmt->limit(); //reset limits
                $anchorStmt->where('count_table.category_id IN (?)', $isAnchor);
                $postCounts += $this->getConnection()->fetchPairs($anchorStmt);
                $anchorStmt = null;
            }
            if ($isNotAnchor) {
                $notAnchorStmt = clone $select;
                $notAnchorStmt->limit(); //reset limits
                $notAnchorStmt->where('count_table.category_id IN (?)', $isNotAnchor);
                $notAnchorStmt->where('count_table.is_parent = 1');
                $postCounts += $this->getConnection()->fetchPairs($notAnchorStmt);
                $notAnchorStmt = null;
            }
            $select = null;
            $this->unsPostCountSelect();
        }

        foreach ($categoryCollection as $category) {
            $_count = 0;
            if (isset($postCounts[$category->getId()])) {
                $_count = $postCounts[$category->getId()];
            }
            $category->setPostCount($_count);
        }

        return $this;
    }

    /**
     * Joins url rewrite rules to collection
     *
     * @deprecated after 1.7.0.2. Method is not used anywhere in the code.
     * @return Mage_Catalog_Model_Resource_Post_Collection
     */
    public function joinUrlRewrite()
    {
        $this->joinTable(
            'core/url_rewrite',
            'post_id=post_id',
            array('request_path'),
            '{{table}}.type = ' . Mage_Core_Model_Url_Rewrite::TYPE_PRODUCT,
            'left'
        );

        return $this;
    }

    /**
     * Add URL rewrites data to post
     * If collection loadded - run processing else set flag
     *
     * @param int|string $categoryId
     * @return Mage_Catalog_Model_Resource_Post_Collection
     */
    public function addUrlRewrite($categoryId = '')
    {
        $this->_addUrlRewrite = true;
        if (Mage::getStoreConfig(Mage_Catalog_Helper_Post::XML_PATH_PRODUCT_URL_USE_CATEGORY)) {
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
            $postIds = array();
            foreach($this->getItems() as $item) {
                $postIds[] = $item->getPostId();
            }
            if (!count($postIds)) {
                return;
            }

            $select = Mage::getSingleton('catalog/factory')->getPostUrlRewriteHelper()
                ->getTableSelect($postIds, $this->_urlRewriteCategory);

            $urlRewrites = array();
            foreach ($this->getConnection()->fetchAll($select) as $row) {
                if (!isset($urlRewrites[$row['post_id']])) {
                    $urlRewrites[$row['post_id']] = $row['request_path'];
                }
            }

            if ($this->_cacheConf) {
                Mage::app()->saveCache(
                    serialize($urlRewrites),
                    $this->_cacheConf['prefix'] . 'urlrewrite',
                    array_merge($this->_cacheConf['tags'], array(Mage_Catalog_Model_Post_Url::CACHE_TAG)),
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
     * @return Mage_Catalog_Model_Resource_Post_Collection
     */
    protected function _preparePostLimitationFilters()
    {
        if (isset($this->_postLimitationFilters['visibility'])
            && !isset($this->_postLimitationFilters['category_id'])
        ) {
            $this->_postLimitationFilters['category_id'] = Mage_Catalog_Model_Category::TREE_DEFAULT_ID;
        }

        return $this;
    }

    /**
     * Apply limitation filters to collection
     * Method allows using one time category post index table (or post website table)
     * for different combinations of store_id/category_id/visibility filter states
     * Method supports multiple changes in one collection object for this parameters
     *
     * @return Mage_Catalog_Model_Resource_Post_Collection
     */
    protected function _applyPostLimitations()
    {
        Mage::dispatchEvent('catalog_post_collection_apply_limitations_before', array(
            'collection'  => $this,
            'category_id' => isset($this->_postLimitationFilters['category_id'])
                ? $this->_postLimitationFilters['category_id']
                : null,
        ));
        $this->_preparePostLimitationFilters();
        $filters = $this->_postLimitationFilters;

        if (!isset($filters['category_id']) && !isset($filters['visibility'])) {
            return $this;
        }

        $conditions = array(
            'cat_index.post_id=main_table.post_id',
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
        Mage::dispatchEvent('catalog_post_collection_apply_limitations_after', array(
            'collection' => $this
        ));

        return $this;
    }


    /**
     * Add category ids to loaded items
     *
     * @return Mage_Catalog_Model_Resource_Post_Collection
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

        $select->from($this->_postCategoryTable, array('post_id', 'category_id'));
        $select->where('post_id IN (?)', $ids);

        $data = $this->getConnection()->fetchAll($select);

        $categoryIds = array();
        foreach ($data as $info) {
            if (isset($categoryIds[$info['post_id']])) {
                $categoryIds[$info['post_id']][] = $info['category_id'];
            } else {
                $categoryIds[$info['post_id']] = array($info['category_id']);
            }
        }


        foreach ($this->getItems() as $item) {
            $postId = $item->getId();
            if (isset($categoryIds[$postId])) {
                $item->setCategoryIds($categoryIds[$postId]);
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
     * @return Mage_Catalog_Model_Resource_Post_Collection
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

<?php
class Mage_Catalog_Model_Resource_Category_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix              = 'catalog_category_collection';

    /**
     * Event object name
     *
     * @var string
     */
    protected $_eventObject              = 'category_collection';

    /**
     * Name of post table
     *
     * @var string
     */
    protected $_postTable;

    /**
     * Load with post count flag
     *
     * @var boolean
     */
    protected $_loadWithPostCount     = false;

    /**
     * Init collection and determine table names
     *
     */
    protected function _construct()
    {
        $this->_init('catalog/category');
        $this->_postTable        = $this->getTable('catalog/category_post');
    }

    /**
     * Add Id filter
     *
     * @param array $categoryIds
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function addIdFilter($categoryIds)
    {
        if (is_array($categoryIds)) {
            if (empty($categoryIds)) {
                $condition = '';
            } else {
                $condition = array('in' => $categoryIds);
            }
        } elseif (is_numeric($categoryIds)) {
            $condition = $categoryIds;
        } elseif (is_string($categoryIds)) {
            $ids = explode(',', $categoryIds);
            if (empty($ids)) {
                $condition = $categoryIds;
            } else {
                $condition = array('in' => $ids);
            }
        }
        $this->addFieldToFilter('category_id', $condition);
        return $this;
    }

    /**
     * Set flag for loading post count
     *
     * @param boolean $flag
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function setLoadPostCount($flag)
    {
        $this->_loadWithPostCount = $flag;
        return $this;
    }

    /**
     * Before collection load
     *
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    protected function _beforeLoad()
    {
        Mage::dispatchEvent($this->_eventPrefix . '_load_before',
                            array($this->_eventObject => $this));
        return parent::_beforeLoad();
    }

    /**
     * After collection load
     *
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    protected function _afterLoad()
    {
        Mage::dispatchEvent($this->_eventPrefix . '_load_after',
                            array($this->_eventObject => $this));

        return parent::_afterLoad();
    }

    /**
     * Load collection
     *
     * @param bool $printQuery
     * @param bool $logQuery
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function load($printQuery = false, $logQuery = false)
    {
        if ($this->isLoaded()) {
            return $this;
        }



        parent::load($printQuery, $logQuery);

        return $this;
    }

    /**
     * Load categories post count
     *
     */
    protected function _loadPostCount()
    {
        $this->loadPostCount($this->_items, true, true);
    }

    /**
     * Load post count for specified items
     *
     * @param array $items
     * @param boolean $countRegular get post count for regular (non-anchor) categories
     * @param boolean $countAnchor get post count for anchor categories
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function loadPostCount($items, $countRegular = true, $countAnchor = true)
    {
        $anchor     = array();
        $regular    = array();

        foreach ($items as $item) {
            if ($item->getIsAnchor()) {
                $anchor[$item->getId()] = $item;
            } else {
                $regular[$item->getId()] = $item;
            }
        }

        if ($countRegular) {
            // Retrieve regular categories post counts
            $regularIds = array_keys($regular);
            if (!empty($regularIds)) {
                $select = $this->_conn->select();
                $select->from(
                        array('main_table' => $this->_postTable),
                        array('category_id', new Magento_Db_Expr('COUNT(main_table.post_id)'))
                    )
                    ->where($this->_conn->quoteInto('main_table.category_id IN(?)', $regularIds))
                    ->group('main_table.category_id');
               
                $counts = $this->_conn->fetchPairs($select);
                foreach ($regular as $item) {
                    if (isset($counts[$item->getId()])) {
                        $item->setPostCount($counts[$item->getId()]);
                    } else {
                        $item->setPostCount(0);
                    }
                }
            }
        }

        if ($countAnchor) {
            // Retrieve Anchor categories post counts
            foreach ($anchor as $item) {
                if ($allChildren = $item->getAllChildren()) {
                    $bind = array(
                        'category_id' => $item->getId(),
                        'c_path'    => $item->getPath() . '/%'
                    );
                    $select = $this->_conn->select();
                    $select->from(
                            array('main_table' => $this->_postTable),
                            new Magento_Db_Expr('COUNT(DISTINCT main_table.post_id)')
                        )
                        ->joinInner(
                            array('e' => $this->getTable('catalog/category')),
                            'main_table.category_id=e.category_id',
                            array()
                        )
                        ->where('e.category_id = :category_id')
                        ->orWhere('e.path LIKE :c_path');
                    
                    $item->setPostCount((int) $this->_conn->fetchOne($select, $bind));
                } else {
                    $item->setPostCount(0);
                }
            }
        }
        return $this;
    }

    /**
     * Add category path filter
     *
     * @param string $regexp
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function addPathFilter($regexp)
    {
        $this->addFieldToFilter('path', array('regexp' => $regexp));
        return $this;
    }

    /**
     * Joins url rewrite rules to collection
     *
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function joinUrlRewrite()
    {
        //Mage::getSingleton('catalog/factory')->getCategoryUrlRewriteHelper();

        return $this;
    }

    /**
     * Add active category filter
     *
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function addIsActiveFilter()
    {
        $this->addFieldToFilter('is_active', 1);
        Mage::dispatchEvent($this->_eventPrefix . '_add_is_active_filter',
                            array($this->_eventObject => $this));
        return $this;
    }

    /**
     * Add name attribute to result
     *
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function addNameToResult()
    {
        $this->addFieldToSelect('name');
        return $this;
    }

    /**
     * Add url rewrite rules to collection
     *
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function addUrlRewriteToResult()
    {
        $this->joinUrlRewrite();
        return $this;
    }

    /**
     * Add category path filter
     *
     * @param array|string $paths
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function addPathsFilter($paths)
    {
        if (!is_array($paths)) {
            $paths = array($paths);
        }
        $write  = $this->getResource()->getWriteConnection();
        $cond   = array();
        foreach ($paths as $path) {
            $cond[] = $write->quoteInto('e.path LIKE ?', "$path%");
        }
        if ($cond) {
            $this->getSelect()->where(join(' OR ', $cond));
        }
        return $this;
    }

    /**
     * Add category level filter
     *
     * @param int|string $level
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function addLevelFilter($level)
    {
        $this->addFieldToFilter('level', array('lteq' => $level));
        return $this;
    }

    /**
     * Add root category filter
     *
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function addRootLevelFilter()
    {
        $this->addFieldToFilter('path', array('neq' => '1'));
        $this->addLevelFilter(1);
        return $this;
    }

    /**
     * Add order field
     *
     * @param string $field
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function addOrderField($field)
    {
        $this->setOrder($field, self::SORT_ORDER_ASC);
        return $this;
    }

    /**
     * Set disable flat flag
     *
     * @param bool $flag
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function setDisableFlat($flag)
    {
        $this->_disableFlat = (bool) $flag;
        return $this;
    }

    /**
     * Retrieve disable flat flag value
     *
     * @return bool
     */
    public function getDisableFlat()
    {
        return $this->_disableFlat;
    }

    /**
     * Retrieve collection empty item
     *
     * @return Mage_Catalog_Model_Category
     */
    public function getNewEmptyItem()
    {
        return new $this->_itemObjectClass(array('disable_flat' => $this->getDisableFlat()));
    }
}

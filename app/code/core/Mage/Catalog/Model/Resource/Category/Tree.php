<?php
class Mage_Catalog_Model_Resource_Category_Tree extends Varien_Data_Tree_Dbp
{
    const ID_FIELD    = 'id';
    const PATH_FIELD  = 'path';
    const ORDER_FIELD = 'order';
    const LEVEL_FIELD = 'level';

    /**
     * Categories resource collection
     *
     * @var Mage_Catalog_Model_Resource_Category_Collection
     */
    protected $_collection;

    /**
     * Join URL rewrites data to collection flag
     *
     * @var boolean
     */
    protected $_joinUrlRewriteIntoCollection     = false;

    /**
     * Inactive categories ids
     *
     * @var array
     */
    protected $_inactiveCategoryIds              = null;

    /**
     * Initialize tree
     *
     */
    public function __construct()
    {
        $resource = Mage::getSingleton('core/resource');

        parent::__construct(
            $resource->getConnection('catalog_write'),
            $resource->getTableName('catalog/category'),
            array(
                Varien_Data_Tree_Dbp::ID_FIELD       => 'category_id',
                Varien_Data_Tree_Dbp::PATH_FIELD     => 'path',
                Varien_Data_Tree_Dbp::ORDER_FIELD    => 'position',
                Varien_Data_Tree_Dbp::LEVEL_FIELD    => 'level',
            )
        );
    }

    public function addCollectionData($collection = null, $sorted = false, $exclude = array(), $toLoad = true,$onlyActive = false)
    {

        if (is_null($collection)) {
            $collection = $this->getCollection($sorted);
        } else {
            $this->setCollection($collection);
        }
		
        if (!is_array($exclude)) {
            $exclude = array($exclude);
        }

        $nodeIds = array();
        foreach ($this->getNodes() as $node) {
            if (!in_array($node->getId(), $exclude)) {
                $nodeIds[] = $node->getId();
            }
        }
        $collection->addIdFilter($nodeIds);
        
        if ($onlyActive) {
            $collection->addFieldToFilter('is_active', 1);
            $collection->addFieldToFilter('include_in_menu', 1);
        }

        if ($this->_joinUrlRewriteIntoCollection) {
            $collection->joinUrlRewrite();
            $this->_joinUrlRewriteIntoCollection = false;
        }

        if ($toLoad) {
            $collection->load();

            foreach ($collection as $category) {
                if ($this->getNodeById($category->getId())) {
                    $this->getNodeById($category->getId())
                        ->addData($category->getData());
                }
            }

            foreach ($this->getNodes() as $node) {
                if (!$collection->getItemById($node->getId()) && $node->getParent()) {
                    $this->removeNode($node);
                }
            }
        }

        return $this;
    }

    /**
     * Get categories collection
     *
     * @param boolean $sorted
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function getCollection($sorted = false)
    {
        if (is_null($this->_collection)) {
            $this->_collection = $this->_getDefaultCollection($sorted);
        }
        return $this->_collection;
    }

    /**
     * Enter description here...
     *
     * @param Mage_Catalog_Model_Resource_Category_Collection $collection
     * @return Mage_Catalog_Model_Resource_Category_Tree
     */
    public function setCollection($collection)
    {
        if (!is_null($this->_collection)) {
            destruct($this->_collection);
        }
        $this->_collection = $collection;
        return $this;
    }

    /**
     * Enter description here...
     *
     * @param boolean $sorted
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    protected function _getDefaultCollection($sorted = false)
    {
        $this->_joinUrlRewriteIntoCollection = true;
        $collection = Mage::getModel('catalog/category')->getCollection();
        /** @var $collection Mage_Catalog_Model_Resource_Category_Collection */

        $collection->addFieldToSelect('*');

        if ($sorted) {
            if (is_string($sorted)) {
                // $sorted is supposed to be field name
                $collection->addFieldToSort($sorted);
            } else {
                $collection->addFieldToSort('name');
            }
        }

        return $collection;
    }

    /**
     * Move tree before
     *
     * @param unknown_type $category
     * @param Varien_Data_Tree_Node $newParent
     * @param Varien_Data_Tree_Node $prevNode
     * @return Mage_Catalog_Model_Resource_Category_Tree
     */
    protected function _beforeMove($category, $newParent, $prevNode)
    {
        Mage::dispatchEvent('catalog_category_tree_move_before', array(
            'category'      => $category,
            'prev_parent'   => $prevNode,
            'parent'        => $newParent
        ));

        return $this;
    }

    /**
     * Executing parents move method and cleaning cache after it
     *
     * @param unknown_type $category
     * @param unknown_type $newParent
     * @param unknown_type $prevNode
     */
    public function move($category, $newParent, $prevNode = null)
    {
        $this->_beforeMove($category, $newParent, $prevNode);
        Mage::getResourceSingleton('catalog/category')->move($category->getId(), $newParent->getId());
        parent::move($category, $newParent, $prevNode);

        $this->_afterMove($category, $newParent, $prevNode);
    }

    /**
     * Move tree after
     *
     * @param unknown_type $category
     * @param Varien_Data_Tree_Node $newParent
     * @param Varien_Data_Tree_Node $prevNode
     * @return Mage_Catalog_Model_Resource_Category_Tree
     */
    protected function _afterMove($category, $newParent, $prevNode)
    {
        Mage::app()->cleanCache(array(Mage_Catalog_Model_Category::CACHE_TAG));

        Mage::dispatchEvent('catalog_category_tree_move_after', array(
            'category'  => $category,
            'prev_node' => $prevNode,
            'parent'    => $newParent
        ));

        return $this;
    }

    /**
     * Load whole category tree, that will include specified categories ids.
     *
     * @param array $ids
     * @param bool $addCollectionData
     * @param bool $updateAnchorPostCount
     * @return Mage_Catalog_Model_Resource_Category_Tree
     */
    public function loadByIds($ids, $addCollectionData = true, $updateAnchorPostCount = true)
    {
        $levelField = $this->_conn->quoteIdentifier('level');
        $pathField  = $this->_conn->quoteIdentifier('path');
        // load first two levels, if no ids specified
        if (empty($ids)) {
            $select = $this->_conn->select()
                ->from($this->_table, 'category_id')
                ->where($levelField . ' <= 2');
            $ids = $this->_conn->fetchCol($select);
        }
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $key => $id) {
            $ids[$key] = (int)$id;
        }

        // collect paths of specified IDs and prepare to collect all their parents and neighbours
        $select = $this->_conn->select()
            ->from($this->_table, array('path', 'level'))
            ->where('category_id IN (?)', $ids);
        $where = array($levelField . '=0' => true);

        foreach ($this->_conn->fetchAll($select) as $item) {
            $pathIds  = explode('/', $item['path']);
            $level = (int)$item['level'];
            while ($level > 0) {
                $pathIds[count($pathIds) - 1] = '%';
                $path = implode('/', $pathIds);
                $where["$levelField=$level AND $pathField LIKE '$path'"] = true;
                array_pop($pathIds);
                $level--;
            }
        }
        $where = array_keys($where);

        // get all required records
        if ($addCollectionData) {
            $select = $this->_createCollectionDataSelect();
        } else {
            $select = clone $this->_select;
            $select->order($this->_orderField . ' ' . Varien_Db_Select::SQL_ASC);
        }
        $select->where(implode(' OR ', $where));

        // get array of records and add them as nodes to the tree
        $arrNodes = $this->_conn->fetchAll($select);
        if (!$arrNodes) {
            return false;
        }
        if ($updateAnchorPostCount) {
            $this->_updateAnchorPostCount($arrNodes);
        }
        $childrenItems = array();
        foreach ($arrNodes as $key => $nodeInfo) {
            $pathToParent = explode('/', $nodeInfo[$this->_pathField]);
            array_pop($pathToParent);
            $pathToParent = implode('/', $pathToParent);
            $childrenItems[$pathToParent][] = $nodeInfo;
        }
        $this->addChildNodes($childrenItems, '', null);
        return $this;
    }

    /**
     * Load array of category parents
     *
     * @param string $path
     * @param bool $addCollectionData
     * @param bool $withRootNode
     * @return array
     */
    public function loadBreadcrumbsArray($path, $addCollectionData = true, $withRootNode = false)
    {
        $pathIds = explode('/', $path);
        if (!$withRootNode) {
            array_shift($pathIds);
        }
        $result = array();
        if (!empty($pathIds)) {
            if ($addCollectionData) {
                $select = $this->_createCollectionDataSelect(false);
            } else {
                $select = clone $this->_select;
            }
            $select
                ->where('main_table.category_id IN(?)', $pathIds)
                ->order($this->_conn->getLengthSql('main_table.path') . ' ' . Varien_Db_Select::SQL_ASC);
            $result = $this->_conn->fetchAll($select);
            $this->_updateAnchorPostCount($result);
        }
        return $result;
    }

    /**
     * Replace posts count with self posts count, if category is non-anchor
     *
     * @param array $data
     */
    protected function _updateAnchorPostCount(&$data)
    {
        foreach ($data as $key => $row) {
            if (0 === (int)$row['is_anchor']) {
                $data[$key]['post_count'] = $row['self_post_count'];
            }
        }
    }

    /**
     * By default everything from entity table is selected
     * + name, is_active and is_anchor
     * Also the correct post_count is selected, depending on is the category anchor or not.
     *
     * @param bool $sorted
     * @return Varien_Db_Select
     */
    protected function _createCollectionDataSelect($sorted = true)
    {
        $select = $this->_getDefaultCollection($sorted ? $this->_orderField : false)
            ->getSelect();
        // count children posts qty plus self posts qty
        $categoriesTable         = Mage::getSingleton('core/resource')->getTableName('catalog/category');
        $categoriesPostsTable = Mage::getSingleton('core/resource')->getTableName('catalog/category_post');

        $subConcat = $this->_conn->getConcatSql(array('main_table.path', $this->_conn->quote('/%')));
        $subSelect = $this->_conn->select()
            ->from(array('see' => $categoriesTable), null)
            ->joinLeft(
                array('scp' => $categoriesPostsTable),
                'see.category_id=scp.category_id',
                array('COUNT(DISTINCT scp.category_id)'))
            ->where('see.category_id = main_table.category_id')
            ->orWhere('see.path LIKE ?', $subConcat);
        $select->columns(array('post_count' => $subSelect));

        $subSelect = $this->_conn->select()
            ->from(array('cp' => $categoriesPostsTable), 'COUNT(cp.category_id)')
            ->where('cp.category_id = main_table.category_id');

        $select->columns(array('self_post_count' => $subSelect));

        return $select;
    }

    /**
     * Get real existing category ids by specified ids
     *
     * @param array $ids
     * @return array
     */
    public function getExistingCategoryIdsBySpecifiedIds($ids)
    {
        if (empty($ids)) {
            return array();
        }
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        $select = $this->_conn->select()
            ->from($this->_table, array('category_id'))
            ->where('category_id IN (?)', $ids);
        return $this->_conn->fetchCol($select);
    }
}

<?php
class Mage_Catalog_Model_Resource_Category extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Category tree object
     *
     * @var Varien_Data_Tree_Db
     */
    protected $_tree;

    /**
     * Catalog posts table name
     *
     * @var string
     */
    protected $_categoryPostTable;


    protected function _construct()
    {
        $this->_init('catalog/category', 'category_id');
        $this->_categoryPostTable =  $this->getTable('catalog/category_post');
    }
    
    

    /**
     * Retrieve category tree object
     *
     * @return Varien_Data_Tree_Db
     */
    protected function _getTree()
    {
        if (!$this->_tree) {
            $this->_tree = Mage::getResourceModel('catalog/category_tree')
                ->load();
        }
        return $this->_tree;
    }

    /**
     * Process category data before delete
     * update children count for parent category
     * delete child categories
     *
     * @param Varien_Object $object
     * @return Mage_Catalog_Model_Resource_Category
     */
    protected function _beforeDelete(Varien_Object $object)
    {
        parent::_beforeDelete($object);

        /**
         * Update children count for all parent categories
         */
        $parentIds = $object->getParentIds();
        if ($parentIds) {
            $childDecrease = $object->getChildrenCount() + 1; // +1 is itself
            $data = array('children_count' => new Magento_Db_Expr('children_count - ' . $childDecrease));
            $where = array('category_id IN(?)' => $parentIds);
            $this->_getWriteAdapter()->update( $this->getMainTable(), $data, $where);
        }
        $this->deleteChildren($object);
        return $this;
    }

    /**
     * Delete children categories of specific category
     *
     * @param Varien_Object $object
     * @return Mage_Catalog_Model_Resource_Category
     */
    public function deleteChildren(Varien_Object $object)
    {
        $adapter = $this->_getWriteAdapter();
        $pathField = $adapter->quoteIdentifier('path');

        $select = $adapter->select()
            ->from($this->getMainTable(), array('category_id'))
            ->where($pathField . ' LIKE :c_path');

        $childrenIds = $adapter->fetchCol($select, array('c_path' => $object->getPath() . '/%'));

        if (!empty($childrenIds)) {
            $adapter->delete(
                $this->getMainTable(),
                array('category_id IN (?)' => $childrenIds)
            );
        }

        /**
         * Add deleted children ids to object
         * This data can be used in after delete event
         */
        $object->setDeletedChildrenIds($childrenIds);
        return $this;
    }

    /**
     * Process category data before saving
     * prepare path and increment children count for parent categories
     *
     * @param Varien_Object $object
     * @return Mage_Catalog_Model_Resource_Category
     */
    protected function _beforeSave(Varien_Object $object)
    {
        parent::_beforeSave($object);

        if (!$object->getChildrenCount()) {
            $object->setChildrenCount(0);
        }
        if ($object->getLevel() === null) {
            $object->setLevel(1);
        }

        if (!$object->getId()) {
            $object->setPosition($this->_getMaxPosition($object->getPath()) + 1);
            $path  = explode('/', $object->getPath());
            $level = count($path);
            $object->setLevel($level);
            if ($level) {
                $object->setParentId($path[$level - 1]);
            }
            $object->setPath($object->getPath() . '/');

            $toUpdateChild = explode('/',$object->getPath());

            $this->_getWriteAdapter()->update(
                $this->getMainTable(),
                array('children_count'  => new Magento_Db_Expr('children_count+1')),
                array('category_id IN(?)' => $toUpdateChild)
            );

        }
        return $this;
    }

    /**
     * Process category data after save category object
     * save related posts ids and update path value
     *
     * @param Varien_Object $object
     * @return Mage_Catalog_Model_Resource_Category
     */
    protected function _afterSave(Varien_Object $object)
    {
        /**
         * Add identifier for new category
         */
        if (substr($object->getPath(), -1) == '/') {
            $object->setPath($object->getPath() . $object->getId());
            $this->_savePath($object);
        }
        if ($object->getData('level')>1) {
        	$this->_saveRewrite($object);
        }
		
        $this->_saveCategoryPosts($object);
        return parent::_afterSave($object);
    }
    
    protected function _saveRewrite($object)
    {
    	$categoryId = $object->getId();
    	$select = $this->_getReadAdapter()->select()
            ->from('core_url_rewrite')
            ->where('id_path = :id_path');
        $bind = array('id_path' => 'category/'.$categoryId);

        $res = $this->_getReadAdapter()->fetchOne($select, $bind);
        
        if ($res) {
            $this->_getWriteAdapter()->update(
                'core_url_rewrite',
                array(
					'request_path' => $object->getData('url_key'),
                	'target_path' => 'catalog/category/view/id/'.$categoryId.'/'),
                array('id_path = ?' => 'category/'.$categoryId)
            );
        } else {
        	$this->_getWriteAdapter()->insertArray(
                'core_url_rewrite',array('id_path','request_path','target_path'),array(array(
                'category/'.$categoryId,
                $object->getData('url_key'),
                'catalog/category/view/id/'.$categoryId.'/'))
            );
        }
        return $this;
    }

    /**
     * Update path field
     *
     * @param Mage_Catalog_Model_Category $object
     * @return Mage_Catalog_Model_Resource_Category
     */
    protected function _savePath($object)
    {
        if ($object->getId()) {
            $this->_getWriteAdapter()->update(
                $this->getMainTable(),
                array('path' => $object->getPath()),
                array('category_id = ?' => $object->getId())
            );
        }
        return $this;
    }

    /**
     * Get maximum position of child categories by specific tree path
     *
     * @param string $path
     * @return int
     */
    protected function _getMaxPosition($path)
    {
        $adapter = $this->getReadConnection();
        $positionField = $adapter->quoteIdentifier('position');
        $level   = count(explode('/', $path));
        $bind = array(
            'c_level' => $level,
            'c_path'  => $path . '/%'
        );
        $select  = $adapter->select()
            ->from($this->getTable('catalog/category'), 'MAX(' . $positionField . ')')
            ->where($adapter->quoteIdentifier('path') . ' LIKE :c_path')
            ->where($adapter->quoteIdentifier('level') . ' = :c_level');

        $position = $adapter->fetchOne($select, $bind);
        if (!$position) {
            $position = 0;
        }
        return $position;
    }

    /**
     * Save category posts relation
     *
     * @param Mage_Catalog_Model_Category $category
     * @return Mage_Catalog_Model_Resource_Category
     */
    protected function _saveCategoryPosts($category)
    {
        $category->setIsChangedPostList(false);
        $id = $category->getId();
        /**
         * new category-post relationships
         */
        $posts = $category->getPostedPosts();

        /**
         * Example re-save category
         */
        if ($posts === null) {
            return $this;
        }

        /**
         * old category-post relationships
         */
        $oldPosts = $category->getPostsPosition();

        $insert = array_diff_key($posts, $oldPosts);
        $delete = array_diff_key($oldPosts, $posts);

        /**
         * Find post ids which are presented in both arrays
         * and saved before (check $oldPosts array)
         */
        $update = array_intersect_key($posts, $oldPosts);
        $update = array_diff_assoc($update, $oldPosts);

        $adapter = $this->_getWriteAdapter();

        /**
         * Delete posts from category
         */
        if (!empty($delete)) {
            $cond = array(
                'post_id IN(?)' => array_keys($delete),
                'category_id=?' => $id
            );
            $adapter->delete($this->_categoryPostTable, $cond);
        }

        /**
         * Add posts to category
         */
        if (!empty($insert)) {
            $data = array();
            foreach ($insert as $postId => $position) {
                $data[] = array(
                    'category_id' => (int)$id,
                    'post_id'  => (int)$postId,
                    'position'    => (int)$position
                );
            }
            $adapter->insertMultiple($this->_categoryPostTable, $data);
        }

        /**
         * Update post positions in category
         */
        if (!empty($update)) {
            foreach ($update as $postId => $position) {
                $where = array(
                    'category_id = ?'=> (int)$id,
                    'post_id = ?' => (int)$postId
                );
                $bind  = array('position' => (int)$position);
                $adapter->update($this->_categoryPostTable, $bind, $where);
            }
        }

        if (!empty($insert) || !empty($delete)) {
            $postIds = array_unique(array_merge(array_keys($insert), array_keys($delete)));
            Mage::dispatchEvent('catalog_category_change_posts', array(
                'category'      => $category,
                'post_ids'   => $postIds
            ));
        }

        if (!empty($insert) || !empty($update) || !empty($delete)) {
            $category->setIsChangedPostList(true);

            /**
             * Setting affected posts to category for third party engine index refresh
             */
            $postIds = array_keys($insert + $delete + $update);
            $category->setAffectedPostIds($postIds);
        }
        return $this;
    }

    /**
     * Get positions of associated to category posts
     *
     * @param Mage_Catalog_Model_Category $category
     * @return array
     */
    public function getPostsPosition($category)
    {
    	
        $select = $this->_getWriteAdapter()->select()
            ->from($this->_categoryPostTable, array('post_id', 'position'))
            ->where('category_id = :category_id');
        $bind = array('category_id' => (int)$category->getId());

        return $this->_getWriteAdapter()->fetchPairs($select, $bind);
    }

    /**
     * Get chlden categories count
     *
     * @param int $categoryId
     * @return int
     */
    public function getChildrenCount($categoryId)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable(), 'children_count')
            ->where('category_id = :category_id');
        $bind = array('category_id' => $categoryId);

        return $this->_getReadAdapter()->fetchOne($select, $bind);
    }

    /**
     * Check if category id exist
     *
     * @param int $entityId
     * @return bool
     */
    public function checkId($entityId)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable(), 'category_id')
            ->where('category_id = :category_id');
        $bind =  array('category_id' => $entityId);

        return $this->_getReadAdapter()->fetchOne($select, $bind);
    }

    /**
     * Check array of category identifiers
     *
     * @param array $ids
     * @return array
     */
    public function verifyIds(array $ids)
    {
        if (empty($ids)) {
            return array();
        }

        $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable(), 'category_id')
            ->where('category_id IN(?)', $ids);

        return $this->_getReadAdapter()->fetchCol($select);
    }

    /**
     * Get count of active/not active children categories
     *
     * @param Mage_Catalog_Model_Category $category
     * @param bool $isActiveFlag
     * @return int
     */
    public function getChildrenAmount($category, $isActiveFlag = true)
    {
 
 
        $table   = $this->getMainTable();
        $adapter = $this->_getReadAdapter();
        $bind = array(
            'active_flag'  => $isActiveFlag,
            'c_path'       => $category->getPath() . '/%'
        );
        $select = $adapter->select()
            ->from(array('m' => $this->getMainTable()), array('COUNT(m.category_id)'))
            ->where('m.path LIKE :c_path')
            ->where('m.is_active = :active_flag');

        return $this->_getReadAdapter()->fetchOne($select, $bind);
    }

    /**
     * Get posts count in category
     *
     * @param Mage_Catalog_Model_Category $category
     * @return int
     */
    public function getPostCount($category)
    {
        $postTable = Mage::getSingleton('core/resource')->getTableName('catalog/category_post');

        $select = $this->getReadConnection()->select()
            ->from(
                array('main_table' => $postTable),
                array(new Magento_Db_Expr('COUNT(main_table.post_id)'))
            )
            ->where('main_table.category_id = :category_id');

        $bind = array('category_id' => (int)$category->getId());
        $counts = $this->getReadConnection()->fetchOne($select, $bind);

        return intval($counts);
    }

    /**
     * Retrieve categories
     *
     * @param integer $parent
     * @param integer $recursionLevel
     * @param boolean|string $sorted
     * @param boolean $asCollection
     * @param boolean $toLoad
     * @return Varien_Data_Tree_Node_Collection|Mage_Catalog_Model_Resource_Category_Collection
     */
    public function getCategories($parent, $recursionLevel = 0, $sorted = false, $asCollection = false, $toLoad = true)
    {
        $tree = Mage::getResourceModel('catalog/category_tree');
        /* @var $tree Mage_Catalog_Model_Resource_Category_Tree */
        $nodes = $tree->loadNode($parent)
            ->loadChildren($recursionLevel)
            ->getChildren();
		
        $tree->addCollectionData(null, $sorted, $parent, $toLoad, true);
		
        if ($asCollection) {
            return $tree->getCollection();
        }
        return $nodes;
    }

    /**
     * Return parent categories of category
     *
     * @param Mage_Catalog_Model_Category $category
     * @return array
     */
    public function getParentCategories($category)
    {
        $pathIds = array_reverse(explode('/', $category->getPath()));
        $categories = Mage::getResourceModel('catalog/category_collection')
        	->addFieldToSelect('category_id')
            ->addFieldToSelect('name')
            ->addFieldToSelect('url_key')
            ->addFieldToFilter('category_id', array('in' => $pathIds))
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('level', array('gt' => 1))
            ->addFieldToFilter('include_in_menu', 1)
            ->load()
            ->getItems();
        return $categories;
    }

    /**
     * Return parent category of current category with own custom design settings
     *
     * @param Mage_Catalog_Model_Category $category
     * @return Mage_Catalog_Model_Category
     */
    public function getParentDesignCategory($category)
    {
        $pathIds = array_reverse($category->getPathIds());
        $collection = $category->getCollection()
            ->addFieldToFilter('category_id', array('in' => $pathIds))
            ->addFieldToFilter('custom_use_parent_settings', array(array('eq' => 0), array('null' => 0)), 'left')
            ->addFieldToFilter('level', array('neq' => 0))
            ->setOrder('level', 'DESC')
            ->load();
        return $collection->getFirstItem();
    }

    /**
     * Prepare base collection setup for get categories list
     *
     * @param Mage_Catalog_Model_Category $category
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    protected function _getChildrenCategoriesBase($category)
    {
        $collection = $category->getCollection();
        $collection->setOrder('position', Varien_Db_Select::SQL_ASC)
            ->joinUrlRewrite();

        return $collection;
    }


    /**
     * Return child categories
     *
     * @param Mage_Catalog_Model_Category $category
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function getChildrenCategories($category)
    {
        $collection = $this->_getChildrenCategoriesBase($category);
        $collection->addFieldToFilter('is_active', 1)
            ->addIdFilter($category->getChildren())
            ->load();

        return $collection;
    }

	
	public function getSiblingCategories($category)
    {
        $collection = $this->_getChildrenCategoriesBase($category);
        $collection->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('parent_id',$category->getParentId())
            ->load();

        return $collection;
    }
    /**
     * Return children categories lists with inactive
     *
     * @param Mage_Catalog_Model_Category $category
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function getChildrenCategoriesWithInactive($category)
    {
        $collection = $this->_getChildrenCategoriesBase($category);
        $collection->addFieldToFilter('parent_id', $category->getId());

        return $collection;
    }

    /**
     * Returns select for category's children.
     *
     * @param $category
     * @param bool $recursive
     * @return Varien_Db_Select
     */
    protected function _getChildrenIdSelect($category, $recursive = true)
    {
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()
            ->from(array('m' => $this->getMainTable()), 'category_id')
            ->where($adapter->quoteIdentifier('path') . ' LIKE ?', $category->getPath() . '/%');

        if (!$recursive) {
            $select->where($adapter->quoteIdentifier('level') . ' <= ?', $category->getLevel() + 1);
        }
        return $select;
    }

    /**
     * Return children ids of category
     *
     * @param Mage_Catalog_Model_Category $category
     * @param boolean $recursive
     * @return array
     */
    public function getChildren($category, $recursive = true)
    {
  
        $adapter      = $this->_getReadAdapter();
        $select = $this->_getChildrenIdSelect($category, $recursive);
        return $adapter->fetchCol($select);
    }

    /**
     * Return IDs of category's children along with inactive categories.
     *
     * @param $category
     * @param bool $recursive
     * @return array
     */
    public function getChildrenIds($category, $recursive = true)
    {
        $select = $this->_getChildrenIdSelect($category, $recursive);
        return $this->_getReadAdapter()->fetchCol($select);
    }

    /**
     * Return all children ids of category (with category id)
     *
     * @param Mage_Catalog_Model_Category $category
     * @return array
     */
    public function getAllChildren($category)
    {
        $children = $this->getChildren($category);
        $myId = array($category->getId());
        $children = array_merge($myId, $children);

        return $children;
    }

    /**
     * Check is category in list of store categories
     *
     * @param Mage_Catalog_Model_Category $category
     * @return boolean
     */
    public function isInRootCategoryList($category)
    {
        $rootCategoryId = Mage_Catalog_Model_Category::TREE_DEFAULT_ID;

        return in_array($rootCategoryId, $category->getParentIds());
    }

    /**
     * Check category is forbidden to delete.
     * If category is root and assigned to store group return false
     *
     * @param integer $categoryId
     * @return boolean
     */
    public function isForbiddenToDelete($categoryId)
    {
        $systemCategoryIds = array(
        	Mage_Catalog_Model_Category::TREE_ROOT_ID,
        	Mage_Catalog_Model_Category::TREE_DEFAULT_ID,
        );

        if (in_array($categoryId,$systemCategoryIds)) {
            return true;
        }
        return false;
    }

    /**
     * Get category path value by its id
     *
     * @param int $categoryId
     * @return string
     */
    public function getCategoryPathById($categoryId)
    {
        $select = $this->getReadConnection()->select()
            ->from($this->getMainTable(), array('path'))
            ->where('category_id = :category_id');
        $bind = array('category_id' => (int)$categoryId);

        return $this->getReadConnection()->fetchOne($select, $bind);
    }

    /**
     * Move category to another parent node
     *
     * @param Mage_Catalog_Model_Category $category
     * @param Mage_Catalog_Model_Category $newParent
     * @param null|int $afterCategoryId
     * @return Mage_Catalog_Model_Resource_Category
     */
    public function changeParent(Mage_Catalog_Model_Category $category, Mage_Catalog_Model_Category $newParent,
        $afterCategoryId = null)
    {
        $childrenCount  = $this->getChildrenCount($category->getId()) + 1;
        $table          = $this->getMainTable();
        $adapter        = $this->_getWriteAdapter();
        $levelFiled     = $adapter->quoteIdentifier('level');
        $pathField      = $adapter->quoteIdentifier('path');

        /**
         * Decrease children count for all old category parent categories
         */
        $adapter->update(
            $table,
            array('children_count' => new Magento_Db_Expr('children_count - ' . $childrenCount)),
            array('category_id IN(?)' => $category->getParentIds())
        );

        /**
         * Increase children count for new category parents
         */
        $adapter->update(
            $table,
            array('children_count' => new Magento_Db_Expr('children_count + ' . $childrenCount)),
            array('category_id IN(?)' => $newParent->getPathIds())
        );

        $position = $this->_processPositions($category, $newParent, $afterCategoryId);

        $newPath          = sprintf('%s/%s', $newParent->getPath(), $category->getId());
        $newLevel         = $newParent->getLevel() + 1;
        $levelDisposition = $newLevel - $category->getLevel();

        /**
         * Update children nodes path
         */
        $adapter->update(
            $table,
            array(
                'path' => new Magento_Db_Expr('REPLACE(' . $pathField . ','.
                    $adapter->quote($category->getPath() . '/'). ', '.$adapter->quote($newPath . '/').')'
                ),
                'level' => new Magento_Db_Expr( $levelFiled . ' + ' . $levelDisposition)
            ),
            array($pathField . ' LIKE ?' => $category->getPath() . '/%')
        );
        /**
         * Update moved category data
         */
        $data = array(
            'path'      => $newPath,
            'level'     => $newLevel,
            'position'  =>$position,
            'parent_id' =>$newParent->getId()
        );
        $adapter->update($table, $data, array('category_id = ?' => $category->getId()));

        // Update category object to new data
        $category->addData($data);

        return $this;
    }

    /**
     * Process positions of old parent category children and new parent category children.
     * Get position for moved category
     *
     * @param Mage_Catalog_Model_Category $category
     * @param Mage_Catalog_Model_Category $newParent
     * @param null|int $afterCategoryId
     * @return int
     */
    protected function _processPositions($category, $newParent, $afterCategoryId)
    {
        $table          = $this->getMainTable();
        $adapter        = $this->_getWriteAdapter();
        $positionField  = $adapter->quoteIdentifier('position');

        $bind = array(
            'position' => new Magento_Db_Expr($positionField . ' - 1')
        );
        $where = array(
            'parent_id = ?'         => $category->getParentId(),
            $positionField . ' > ?' => $category->getPosition()
        );
        $adapter->update($table, $bind, $where);

        /**
         * Prepare position value
         */
        if ($afterCategoryId) {
            $select = $adapter->select()
                ->from($table,'position')
                ->where('category_id = :category_id');
            $position = $adapter->fetchOne($select, array('category_id' => $afterCategoryId));

            $bind = array(
                'position' => new Magento_Db_Expr($positionField . ' + 1')
            );
            $where = array(
                'parent_id = ?' => $newParent->getId(),
                $positionField . ' > ?' => $position
            );
            $adapter->update($table,$bind,$where);
        } elseif ($afterCategoryId !== null) {
            $position = 0;
            $bind = array(
                'position' => new Magento_Db_Expr($positionField . ' + 1')
            );
            $where = array(
                'parent_id = ?' => $newParent->getId(),
                $positionField . ' > ?' => $position
            );
            $adapter->update($table,$bind,$where);
        } else {
            $select = $adapter->select()
                ->from($table,array('position' => new Magento_Db_Expr('MIN(' . $positionField. ')')))
                ->where('parent_id = :parent_id');
            $position = $adapter->fetchOne($select, array('parent_id' => $newParent->getId()));
        }
        $position += 1;

        return $position;
    }
    
    /***
     * $obj Mage_Catalog_Model_Category
     */
    public function validate($obj) {
    	return true;
    }
}

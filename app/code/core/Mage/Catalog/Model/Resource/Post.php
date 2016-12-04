<?php
class Mage_Catalog_Model_Resource_Post extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Post to category linkage table
     *
     * @var string
     */
    protected $_postCategoryTable;


	protected function _construct()
    {
        $this->_init('catalog/post', 'post_id');
        $this->_postCategoryTable = $this->getTable('catalog/category_post');
    }

    /**
     * Retrieve post category identifiers
     *
     * @param Mage_Catalog_Model_Post $post
     * @return array
     */
    public function getCategoryIds($post)
    {
        $adapter = $this->_getReadAdapter();

        $select = $adapter->select()
            ->from($this->_postCategoryTable, 'category_id')
            ->where('post_id = ?', (int)$post->getId());
		$res = $adapter->fetchCol($select);
		
        return $res;
    }

    /**
     * Process post data before save
     *
     * @param Varien_Object $object
     * @return Mage_Catalog_Model_Resource_Post
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
     * Save data related with post
     *
     * @param Varien_Object $post
     * @return Mage_Catalog_Model_Resource_Post
     */
    protected function _afterSave(Varien_Object $post)
    {
        $this->_saveCategories($post);
        return parent::_afterSave($post);
    }

    /**
     * Save post category relations
     *
     * @param Varien_Object $object
     * @return Mage_Catalog_Model_Resource_Post
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
                    'post_id'  => (int)$object->getId(),
                    'position'    => 1
                );
            }
            if ($data) {
                $write->insertMultiple($this->_postCategoryTable, $data);
            }
        }

        if (!empty($delete)) {
            foreach ($delete as $categoryId) {
                $where = array(
                    'post_id = ?'  => (int)$object->getId(),
                    'category_id = ?' => (int)$categoryId,
                );

                $write->delete($this->_postCategoryTable, $where);
            }
        }

        if (!empty($insert) || !empty($delete)) {
            $object->setAffectedCategoryIds(array_merge($insert, $delete));
            $object->setIsChangedCategories(true);
        }

        return $this;
    }
    /**
     * Get collection of post categories
     *
     * @param Mage_Catalog_Model_Post $post
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function getCategoryCollection($post)
    {
        $collection = Mage::getResourceModel('catalog/category_collection')
            ->joinField('post_id',
                'catalog/category_post',
                'post_id',
                'category_id = category_id',
                null)
            ->addFieldToFilter('post_id', (int)$post->getId());
        return $collection;
    }
    public function validate($obj) {
    	return true;
    }
}

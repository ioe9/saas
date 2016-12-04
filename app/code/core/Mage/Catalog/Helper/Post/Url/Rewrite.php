<?php
class Mage_Catalog_Helper_Post_Url_Rewrite
    implements Mage_Catalog_Helper_Post_Url_Rewrite_Interface
{
    /**
     * Adapter instance
     *
     * @var Varien_Db_Adapter_Interface
     */
    protected $_connection;

    /**
     * Resource instance
     *
     * @var Mage_Core_Model_Resource
     */
    protected $_resource;

    /**
     * Initialize resource and connection instances
     *
     * @param array $args
     */
    public function __construct(array $args = array())
    {
        $this->_resource = Mage::getSingleton('core/resource');
        $this->_connection = !empty($args['connection']) ? $args['connection'] : $this->_resource
            ->getConnection(Mage_Core_Model_Resource::DEFAULT_READ_RESOURCE);
    }

    /**
     * Prepare and return select
     *
     * @param array $postIds
     * @param int $categoryId
     * @param int $storeId
     * @return Varien_Db_Select
     */
    public function getTableSelect(array $postIds, $categoryId)
    {
        $select = $this->_connection->select()
            ->from($this->_resource->getTableName('core/url_rewrite'), array('post_id', 'request_path'))
            ->where('is_system = ?', 1)
            ->where('category_id = ? OR category_id IS NULL', (int)$categoryId)
            ->where('post_id IN(?)', $postIds)
            ->order('category_id ' . Varien_Data_Collection::SORT_ORDER_DESC);
        return $select;
    }

    /**
     * Prepare url rewrite left join statement for given select instance and store_id parameter.
     *
     * @param Varien_Db_Select $select
     * @param int $storeId
     * @return Mage_Catalog_Helper_Post_Url_Rewrite_Interface
     */
    public function joinTableToSelect(Varien_Db_Select $select)
    {
        $select->joinLeft(
            array('url_rewrite' => $this->_resource->getTableName('core/url_rewrite')),
            'url_rewrite.post_id = main_table.post_id AND url_rewrite.is_system = 1 AND ' .
                $this->_connection->quoteInto('url_rewrite.category_id IS NULL AND ') .
                $this->_connection->prepareSqlCondition('url_rewrite.id_path', array('like' => 'post/%')),
            array('request_path' => 'url_rewrite.request_path'));
        return $this;
    }
}

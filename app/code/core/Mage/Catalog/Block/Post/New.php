<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * New posts block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Block_Post_New extends Mage_Catalog_Block_Post_Abstract
{
    /**
     * Default value for posts count that will be shown
     */
    const DEFAULT_PRODUCTS_COUNT = 10;

    /**
     * Posts count
     *
     * @var null
     */
    protected $_postsCount;

    /**
     * Initialize block's cache
     */
    protected function _construct()
    {
        parent::_construct();

        $this->addColumnCountLayoutDepend('empty', 6)
            ->addColumnCountLayoutDepend('one_column', 5)
            ->addColumnCountLayoutDepend('two_columns_left', 4)
            ->addColumnCountLayoutDepend('two_columns_right', 4)
            ->addColumnCountLayoutDepend('three_columns', 3);

        $this->addData(array('cache_lifetime' => 86400));
        $this->addCacheTag(Mage_Catalog_Model_Post::CACHE_TAG);
    }

    /**
     * Get Key pieces for caching block content
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array(
           'CATALOG_PRODUCT_NEW',
           Mage::app()->getStore()->getId(),
           Mage::getDesign()->getPackageName(),
           Mage::getDesign()->getTheme('template'),
           Mage::getSingleton('customer/session')->getCustomerGroupId(),
           'template' => $this->getTemplate(),
           $this->getPostsCount()
        );
    }

    /**
     * Prepare and return post collection
     *
     * @return Mage_Catalog_Model_Resource_Post_Collection|Object|Varien_Data_Collection
     */
    protected function _getPostCollection()
    {
        $todayStartOfDayDate  = Mage::getSingleton('core/date')->gmtDate('Y-m-d ').'00:00:00';
        $todayEndOfDayDate  = Mage::getSingleton('core/date')->gmtDate('Y-m-d ').'23:59:59';

        /** @var $collection Mage_Catalog_Model_Resource_Post_Collection */
        $collection = Mage::getResourceModel('catalog/post_collection');
        $collection->setVisibility(Mage::getSingleton('catalog/post_visibility')->getVisibleInCatalogIds());


        $collection = $this->_addPostAttributesAndPrices($collection)
            ->addStoreFilter()
            ->addFieldToFilter('news_from_date', array('or'=> array(
                0 => array('date' => true, 'to' => $todayEndOfDayDate),
                1 => array('is' => new Magento_Db_Expr('null')))
            ), 'left')
            ->addFieldToFilter('news_to_date', array('or'=> array(
                0 => array('date' => true, 'from' => $todayStartOfDayDate),
                1 => array('is' => new Magento_Db_Expr('null')))
            ), 'left')
            ->addFieldToFilter(
                array(
                    array('attribute' => 'news_from_date', 'is'=>new Magento_Db_Expr('not null')),
                    array('attribute' => 'news_to_date', 'is'=>new Magento_Db_Expr('not null'))
                    )
              )
            ->addAttributeToSort('news_from_date', 'desc')
            ->setPageSize($this->getPostsCount())
            ->setCurPage(1)
        ;

        return $collection;
    }

    /**
     * Prepare collection with new posts
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml()
    {
        $this->setPostCollection($this->_getPostCollection());
        return parent::_beforeToHtml();
    }

    /**
     * Set how much post should be displayed at once.
     *
     * @param $count
     * @return Mage_Catalog_Block_Post_New
     */
    public function setPostsCount($count)
    {
        $this->_postsCount = $count;
        return $this;
    }

    /**
     * Get how much posts should be displayed at once.
     *
     * @return int
     */
    public function getPostsCount()
    {
        if (null === $this->_postsCount) {
            $this->_postsCount = self::DEFAULT_PRODUCTS_COUNT;
        }
        return $this->_postsCount;
    }
}

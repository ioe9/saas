<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * New posts widget
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Block_Post_Widget_New extends Mage_Catalog_Block_Post_New
    implements Mage_Widget_Block_Interface
{
    /**
     * Display posts type
     */
    const DISPLAY_TYPE_ALL_PRODUCTS         = 'all_posts';
    const DISPLAY_TYPE_NEW_PRODUCTS         = 'new_posts';

    /**
     * Default value whether show pager or not
     */
    const DEFAULT_SHOW_PAGER                = false;

    /**
     * Default value for posts per page
     */
    const DEFAULT_PRODUCTS_PER_PAGE         = 5;

    /**
     * Name of request parameter for page number value
     */
    const PAGE_VAR_NAME                     = 'np';

    /**
     * Instance of pager block
     *
     * @var Mage_Catalog_Block_Post_Widget_Html_Pager
     */
    protected $_pager;

    /**
     * Default post amount per row
     *
     * @var int
     */
    protected $_defaultColumnCount = 5;

    /**
     * Initialize block's cache and template settings
     */
    protected function _construct()
    {
        parent::_construct();
        $this->addPriceBlockType('bundle', 'bundle/catalog_post_price', 'bundle/catalog/post/price.phtml');
    }

    /**
     * Post collection initialize process
     *
     * @return Mage_Catalog_Model_Resource_Post_Collection|Object|Varien_Data_Collection
     */
    protected function _getPostCollection()
    {
        switch ($this->getDisplayType()) {
            case self::DISPLAY_TYPE_NEW_PRODUCTS:
                $collection = parent::_getPostCollection();
                break;
            default:
                $collection = $this->_getRecentlyAddedPostsCollection();
                break;
        }
        return $collection;
    }

    /**
     * Prepare collection for recent post list
     *
     * @return Mage_Catalog_Model_Resource_Post_Collection|Object|Varien_Data_Collection
     */
    protected function _getRecentlyAddedPostsCollection()
    {
        /** @var $collection Mage_Catalog_Model_Resource_Post_Collection */
        $collection = Mage::getResourceModel('catalog/post_collection');
        $collection->setVisibility(Mage::getSingleton('catalog/post_visibility')->getVisibleInCatalogIds());

        $collection = $this->_addPostAttributesAndPrices($collection)
            ->addStoreFilter()
            ->addAttributeToSort('created_at', 'desc')
            ->setPageSize($this->getPostsCount())
            ->setCurPage(1)
        ;
        return $collection;
    }

    /**
     * Get key pieces for caching block content
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array_merge(parent::getCacheKeyInfo(), array(
            $this->getDisplayType(),
            $this->getPostsPerPage(),
            intval($this->getRequest()->getParam(self::PAGE_VAR_NAME))
        ));
    }

    /**
     * Retrieve display type for posts
     *
     * @return string
     */
    public function getDisplayType()
    {
        if (!$this->hasData('display_type')) {
            $this->setData('display_type', self::DISPLAY_TYPE_ALL_PRODUCTS);
        }
        return $this->getData('display_type');
    }

    /**
     * Retrieve how much posts should be displayed
     *
     * @return int
     */
    public function getPostsCount()
    {
        if (!$this->hasData('posts_count')) {
            return parent::getPostsCount();
        }
        return $this->getData('posts_count');
    }

    /**
     * Retrieve how much posts should be displayed
     *
     * @return int
     */
    public function getPostsPerPage()
    {
        if (!$this->hasData('posts_per_page')) {
            $this->setData('posts_per_page', self::DEFAULT_PRODUCTS_PER_PAGE);
        }
        return $this->getData('posts_per_page');
    }

    /**
     * Return flag whether pager need to be shown or not
     *
     * @return bool
     */
    public function showPager()
    {
        if (!$this->hasData('show_pager')) {
            $this->setData('show_pager', self::DEFAULT_SHOW_PAGER);
        }
        return (bool)$this->getData('show_pager');
    }

    /**
     * Render pagination HTML
     *
     * @return string
     */
    public function getPagerHtml()
    {
        if ($this->showPager()) {
            if (!$this->_pager) {
                $this->_pager = $this->getLayout()
                    ->createBlock('catalog/post_widget_html_pager', 'widget.new.post.list.pager');

                $this->_pager->setUseContainer(true)
                    ->setShowAmounts(true)
                    ->setShowPerPage(false)
                    ->setPageVarName(self::PAGE_VAR_NAME)
                    ->setLimit($this->getPostsPerPage())
                    ->setTotalLimit($this->getPostsCount())
                    ->setCollection($this->getPostCollection());
            }
            if ($this->_pager instanceof Mage_Core_Block_Abstract) {
                return $this->_pager->toHtml();
            }
        }
        return '';
    }
}

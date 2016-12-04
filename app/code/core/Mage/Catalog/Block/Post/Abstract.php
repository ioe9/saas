<?php
abstract class Mage_Catalog_Block_Post_Abstract extends Mage_Core_Block_Template
{
    /**
     * Review block instance
     *
     * @var null|Mage_Review_Block_Helper
     */
    protected $_reviewsHelperBlock;

    /**
     * Default post amount per row
     *
     * @var int
     */
    protected $_defaultColumnCount = 3;

    /**
     * Post amount per row depending on custom page layout of category
     *
     * @var array
     */
    protected $_columnCountLayoutDepend = array();

    /**
     * Return model instance
     *
     * @param string $className
     * @param array $arguments
     * @return Mage_Core_Model_Abstract
     */
    protected function _getSingletonModel($className, $arguments = array())
    {
        return Mage::getSingleton($className, $arguments);
    }

    /**
     * Return link to Add to Wishlist
     *
     * @param Mage_Catalog_Model_Post $post
     * @return string
     */
    public function getAddToWishlistUrl($post)
    {
        return $this->helper('wishlist')->getAddUrl($post);
    }


    /**
     * Get post reviews summary
     *
     * @param Mage_Catalog_Model_Post $post
     * @param bool $templateType
     * @param bool $displayIfNoReviews
     * @return string
     */
    public function getReviewsSummaryHtml(Mage_Catalog_Model_Post $post, $templateType = false,
        $displayIfNoReviews = false)
    {
        if ($this->_initReviewsHelperBlock()) {
            return $this->_reviewsHelperBlock->getSummaryHtml($post, $templateType, $displayIfNoReviews);
        }

        return '';
    }

    /**
     * Add/replace reviews summary template by type
     *
     * @param string $type
     * @param string $template
     * @return string
     */
    public function addReviewSummaryTemplate($type, $template)
    {
        if ($this->_initReviewsHelperBlock()) {
            $this->_reviewsHelperBlock->addTemplate($type, $template);
        }

        return '';
    }

    /**
     * Create reviews summary helper block once
     *
     * @return boolean
     */
    protected function _initReviewsHelperBlock()
    {
        if (!$this->_reviewsHelperBlock) {
            if (!Mage::helper('catalog')->isModuleEnabled('Mage_Review')) {
                return false;
            } else {
                $this->_reviewsHelperBlock = $this->getLayout()->createBlock('review/helper');
            }
        }

        return true;
    }

    /**
     * Retrieve currently viewed post object
     *
     * @return Mage_Catalog_Model_Post
     */
    public function getPost()
    {
        if (!$this->hasData('post')) {
            $this->setData('post', Mage::registry('post'));
        }
        return $this->getData('post');
    }

    /*
     * Calls the object's to Html method.
     * This method exists to make the code more testable.
     * By having a protected wrapper for the final method toHtml, we can 'mock' out this method
     * when unit testing
     *
     *  @return string
     */
    protected function callParentToHtml()
    {
        return $this->toHtml();
    }
    /**
     * Retrieve given media attribute label or post name if no label
     *
     * @param Mage_Catalog_Model_Post $post
     * @param string $mediaAttributeCode
     *
     * @return string
     */
    public function getImageLabel($post = null, $mediaAttributeCode = 'image')
    {
        if (is_null($post)) {
            $post = $this->getPost();
        }

        $label = $post->getData($mediaAttributeCode . '_label');
        if (empty($label)) {
            $label = $post->getName();
        }

        return $label;
    }

    /**
     * Retrieve Post URL using UrlDataObject
     *
     * @param Mage_Catalog_Model_Post $post
     * @param array $additional the route params
     * @return string
     */
    public function getPostUrl($post, $additional = array())
    {
        if ($this->hasPostUrl($post)) {
            if (!isset($additional['_escape'])) {
                $additional['_escape'] = true;
            }
            return $post->getUrlModel()->getUrl($post, $additional);
        }
        return '#';
    }

    /**
     * Check Post has URL
     *
     * @param Mage_Catalog_Model_Post $post
     * @return bool
     *
     */
    public function hasPostUrl($post)
    {
        if ($post->getVisibleInSiteVisibilities()) {
            return true;
        }
        return false;
    }

    /**
     * Retrieve post amount per row
     *
     * @return int
     */
    public function getColumnCount()
    {
        if (!$this->_getData('column_count')) {
            $pageLayout = $this->getPageLayout();
            if ($pageLayout && $this->getColumnCountLayoutDepend($pageLayout->getCode())) {
                $this->setData(
                    'column_count',
                    $this->getColumnCountLayoutDepend($pageLayout->getCode())
                );
            } else {
                $this->setData('column_count', $this->_defaultColumnCount);
            }
        }

        return (int) $this->_getData('column_count');
    }

    /**
     * Add row size depends on page layout
     *
     * @param string $pageLayout
     * @param int $columnCount
     * @return Mage_Catalog_Block_Post_List
     */
    public function addColumnCountLayoutDepend($pageLayout, $columnCount)
    {
        $this->_columnCountLayoutDepend[$pageLayout] = $columnCount;
        return $this;
    }

    /**
     * Remove row size depends on page layout
     *
     * @param string $pageLayout
     * @return Mage_Catalog_Block_Post_List
     */
    public function removeColumnCountLayoutDepend($pageLayout)
    {
        if (isset($this->_columnCountLayoutDepend[$pageLayout])) {
            unset($this->_columnCountLayoutDepend[$pageLayout]);
        }

        return $this;
    }

    /**
     * Retrieve row size depends on page layout
     *
     * @param string $pageLayout
     * @return int|boolean
     */
    public function getColumnCountLayoutDepend($pageLayout)
    {
        if (isset($this->_columnCountLayoutDepend[$pageLayout])) {
            return $this->_columnCountLayoutDepend[$pageLayout];
        }

        return false;
    }

    /**
     * Retrieve current page layout
     *
     * @return Varien_Object
     */
    public function getPageLayout()
    {
        return $this->helper('page/layout')->getCurrentPageLayout();
    }

    /**
     * If exists price template block, retrieve price blocks from it
     *
     * @return Mage_Catalog_Block_Post_Abstract
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        return $this;
    }
}

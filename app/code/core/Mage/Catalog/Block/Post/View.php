<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Post View block
 *
 * @category Mage
 * @package  Mage_Catalog
 * @module   Catalog
 * @author   Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Block_Post_View extends Mage_Catalog_Block_Post_Abstract
{
    /**
     * Default MAP renderer type
     *
     * @var string
     */
    protected $_mapRenderer = 'msrp_item';

    /**
     * Add meta information from post to head block
     *
     * @return Mage_Catalog_Block_Post_View
     */
    protected function _prepareLayout()
    {
        $this->getLayout()->createBlock('catalog/breadcrumbs');
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $post = $this->getPost();
            $title = $post->getMetaTitle();
            if ($title) {
                $headBlock->setTitle($title);
            }
            $keyword = $post->getMetaKeyword();
            $currentCategory = Mage::registry('current_category');
            if ($keyword) {
                $headBlock->setKeywords($keyword);
            } elseif ($currentCategory) {
                $headBlock->setKeywords($post->getName());
            }
            $description = $post->getMetaDescription();
            if ($description) {
                $headBlock->setDescription( ($description) );
            } else {
                $headBlock->setDescription(Mage::helper('core/string')->substr($post->getDescription(), 0, 255));
            }
            if ($this->helper('catalog/post')->canUseCanonicalTag()) {
                $params = array('_ignore_category' => true);
                $headBlock->addLinkRel('canonical', $post->getUrlModel()->getUrl($post, $params));
            }
        }

        return parent::_prepareLayout();
    }

    /**
     * Retrieve current post model
     *
     * @return Mage_Catalog_Model_Post
     */
    public function getPost()
    {
        if (!Mage::registry('post') && $this->getPostId()) {
            $post = Mage::getModel('catalog/post')->load($this->getPostId());
            Mage::register('post', $post);
        }
        return Mage::registry('post');
    }

    /**
     * Check if post can be emailed to friend
     *
     * @return bool
     */
    public function canEmailToFriend()
    {
        $sendToFriendModel = Mage::registry('send_to_friend_model');
        return $sendToFriendModel && $sendToFriendModel->canEmailToFriend();
    }

    /**
     * Retrieve url for direct adding post to cart
     *
     * @param Mage_Catalog_Model_Post $post
     * @param array $additional
     * @return string
     */
    public function getAddToCartUrl($post, $additional = array())
    {
        if ($this->hasCustomAddToCartUrl()) {
            return $this->getCustomAddToCartUrl();
        }

        if ($this->getRequest()->getParam('wishlist_next')) {
            $additional['wishlist_next'] = 1;
        }

        $addUrlKey = Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED;
        $addUrlValue = Mage::getUrl('*/*/*', array('_use_rewrite' => true, '_current' => true));
        $additional[$addUrlKey] = Mage::helper('core')->urlEncode($addUrlValue);

        return $this->helper('checkout/cart')->getAddUrl($post, $additional);
    }

    /**
     * Get JSON encoded configuration array which can be used for JS dynamic
     * price calculation depending on post options
     *
     * @return string
     */
    public function getJsonConfig()
    {
        $config = array();

        return Mage::helper('core')->jsonEncode($config);
    }

    /**
     * Return true if post has options
     *
     * @return bool
     */
    public function hasOptions()
    {
        if ($this->getPost()->hasOptions($this->getPost())) {
            return true;
        }
        return false;
    }

    /**
     * Check if post has required options
     *
     * @return bool
     */
    public function hasRequiredOptions()
    {
        return $this->getPost()->getTypeInstance(true)->hasRequiredOptions($this->getPost());
    }

    /**
     * Define if setting of post options must be shown instantly.
     * Used in case when options are usually hidden and shown only when user
     * presses some button or link. In editing mode we better show these options
     * instantly.
     *
     * @return bool
     */
    public function isStartCustomization()
    {
        return $this->getPost()->getConfigureMode() || Mage::app()->getRequest()->getParam('startcustomization');
    }

    /**
     * Get default qty - either as preconfigured, or as 1.
     * Also restricts it by minimal qty.
     *
     * @param null|Mage_Catalog_Model_Post $post
     * @return int|float
     */
    public function getPostDefaultQty($post = null)
    {
        if (!$post) {
            $post = $this->getPost();
        }

        $qty = $this->getMinimalQty($post);
        $config = $post->getPreconfiguredValues();
        $configQty = $config->getQty();
        if ($configQty > $qty) {
            $qty = $configQty;
        }

        return $qty;
    }

    /**
     * Retrieve block cache tags
     *
     * @return array
     */
    public function getCacheTags()
    {
        return array_merge(parent::getCacheTags(), $this->getPost()->getCacheIdTags());
    }
}

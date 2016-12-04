<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Catalog data helper
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Helper_Data extends Mage_Core_Helper_Abstract
{
    const PRICE_SCOPE_GLOBAL               = 0;
    const PRICE_SCOPE_WEBSITE              = 1;
    const XML_PATH_PRICE_SCOPE             = 'catalog/price/scope';
    const XML_PATH_SEO_SAVE_HISTORY        = 'catalog/seo/save_rewrites_history';
    const CONFIG_USE_STATIC_URLS           = 'cms/wysiwyg/use_static_urls_in_catalog';
    const CONFIG_PARSE_URL_DIRECTIVES      = 'catalog/frontend/parse_url_directives';
    const XML_PATH_CONTENT_TEMPLATE_FILTER = 'global/catalog/content/tempate_filter';
    const XML_PATH_DISPLAY_PRODUCT_COUNT   = 'catalog/layered_navigation/display_post_count';

    /**
     * Minimum advertise price constants
     */
    const XML_PATH_MSRP_ENABLED = 'sales/msrp/enabled';
    const XML_PATH_MSRP_DISPLAY_ACTUAL_PRICE_TYPE = 'sales/msrp/display_price_type';
    const XML_PATH_MSRP_APPLY_TO_ALL = 'sales/msrp/apply_for_all';
    const XML_PATH_MSRP_EXPLANATION_MESSAGE = 'sales/msrp/explanation_message';
    const XML_PATH_MSRP_EXPLANATION_MESSAGE_WHATS_THIS = 'sales/msrp/explanation_message_whats_this';


    /**
     * Breadcrumb Path cache
     *
     * @var string
     */
    protected $_categoryPath;

    /**
     * Array of post types that MAP enabled
     *
     * @var array
     */
    protected $_mapApplyToPostType = null;

    /**
     * Return current category path or get it from current category
     * and creating array of categories|post paths for breadcrumbs
     *
     * @return string
     */
    public function getBreadcrumbPath()
    {
        if (!$this->_categoryPath) {

            $path = array();
            if ($category = $this->getCategory()) {
                $pathId = $category->getPath();
               
                $pathIds = array_reverse(explode('/', $pathId));

                $categories = $category->getParentCategories();
                
                // add category path breadcrumb
                foreach ($categories as $_category) {
                	$categoryId = $_category->getId();
                	
                    if (in_array($categoryId,$pathIds) && $_category->getName()) {
                        $path['category'.$categoryId] = array(
                            'label' => $_category->getName(),
                            'link' => $this->_isCategoryLink($categoryId) ? $_category->getUrl() : ''
                        );
                    }
                }
            }

            if ($this->getPost()) {
                $path['post'] = array('label'=>$this->getPost()->getName());
            }

            $this->_categoryPath = $path;
        }
        return $this->_categoryPath;
    }

    /**
     * Check is category link
     *
     * @param int $categoryId
     * @return bool
     */
    protected function _isCategoryLink($categoryId)
    {
        if ($this->getPost()) {
            return true;
        }
        if ($categoryId != $this->getCategory()->getId()) {
            return true;
        }
        return false;
    }

    /**
     * Return current category object
     *
     * @return Mage_Catalog_Model_Category|null
     */
    public function getCategory()
    {
        return Mage::registry('current_category');
    }

    /**
     * Retrieve current Post object
     *
     * @return Mage_Catalog_Model_Post|null
     */
    public function getPost()
    {
        return Mage::registry('current_post');
    }

    /**
     * Retrieve Visitor/Customer Last Viewed URL
     *
     * @return string
     */
    public function getLastViewedUrl()
    {
        if ($postId = Mage::getSingleton('catalog/session')->getLastViewedPostId()) {
            $post = Mage::getModel('catalog/post')->load($postId);
            /* @var $post Mage_Catalog_Model_Post */
            if (Mage::helper('catalog/post')->canShow($post, 'catalog')) {
                return $post->getPostUrl();
            }
        }
        if ($categoryId = Mage::getSingleton('catalog/session')->getLastViewedCategoryId()) {
            $category = Mage::getModel('catalog/category')->load($categoryId);
            /* @var $category Mage_Catalog_Model_Category */
            if (!Mage::helper('catalog/category')->canShow($category)) {
                return '';
            }
            return $category->getCategoryUrl();
        }
        return '';
    }

    /**
     * Split SKU of an item by dashes and spaces
     * Words will not be broken, unless thir length is greater than $length
     *
     * @param string $sku
     * @param int $length
     * @return array
     */
    public function splitSku($sku, $length = 30)
    {
        return Mage::helper('core/string')->str_split($sku, $length, true, false, '[\-\s]');
    }

    /**
     * Retrieve attribute hidden fields
     *
     * @return array
     */
    public function getAttributeHiddenFields()
    {
        if (Mage::registry('attribute_type_hidden_fields')) {
            return Mage::registry('attribute_type_hidden_fields');
        } else {
            return array();
        }
    }

    /**
     * Retrieve attribute disabled types
     *
     * @return array
     */
    public function getAttributeDisabledTypes()
    {
        if (Mage::registry('attribute_type_disabled_types')) {
            return Mage::registry('attribute_type_disabled_types');
        } else {
            return array();
        }
    }

    /**
     * Retrieve Catalog Price Scope
     *
     * @return int
     */
    public function getPriceScope()
    {
        return Mage::getStoreConfig(self::XML_PATH_PRICE_SCOPE);
    }

    /**
     * Is Global Price
     *
     * @return bool
     */
    public function isPriceGlobal()
    {
        return $this->getPriceScope() == self::PRICE_SCOPE_GLOBAL;
    }

    /**
     * Indicate whether to save URL Rewrite History or not (create redirects to old URLs)
     *
     * @param int $storeId Store View
     * @return bool
     */
    public function shouldSaveUrlRewritesHistory($storeId = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_SEO_SAVE_HISTORY, $storeId);
    }

    /**
     * Check if the store is configured to use static URLs for media
     *
     * @return bool
     */
    public function isUsingStaticUrlsAllowed()
    {
        return Mage::getStoreConfigFlag(self::CONFIG_USE_STATIC_URLS, $this->_storeId);
    }

    /**
     * Check if the parsing of URL directives is allowed for the catalog
     *
     * @return bool
     */
    public function isUrlDirectivesParsingAllowed()
    {
        return Mage::getStoreConfigFlag(self::CONFIG_PARSE_URL_DIRECTIVES, $this->_storeId);
    }

    /**
     * Retrieve template processor for catalog content
     *
     * @return Varien_Filter_Template
     */
    public function getPageTemplateProcessor()
    {
        $model = (string)Mage::getConfig()->getNode(self::XML_PATH_CONTENT_TEMPLATE_FILTER);
        return Mage::getModel($model);
    }

    /**
    * Initialize mapping for old and new field names
    *
    * @return array
    */
    public function getOldFieldMap()
    {
        $node = Mage::getConfig()->getNode('global/catalog_post/old_fields_map');
        if ($node === false) {
            return array();
        }
        return (array) $node;
    }
    /**
     * Check if Minimum Advertised Price is enabled
     *
     * @return bool
     */
    public function isMsrpEnabled()
    {
        return (bool)Mage::getStoreConfig(self::XML_PATH_MSRP_ENABLED, $this->_storeId);
    }

    /**
     * Return MAP display actual type
     *
     * @return null|string
     */
    public function getMsrpDisplayActualPriceType()
    {
        return Mage::getStoreConfig(self::XML_PATH_MSRP_DISPLAY_ACTUAL_PRICE_TYPE, $this->_storeId);
    }

    /**
     * Check if MAP apply to all posts
     *
     * @return bool
     */
    public function isMsrpApplyToAll()
    {
        return (bool)Mage::getStoreConfig(self::XML_PATH_MSRP_APPLY_TO_ALL, $this->_storeId);
    }

    /**
     * Return MAP explanation message
     *
     * @return string
     */
    public function getMsrpExplanationMessage()
    {
        return $this->escapeHtml(
            Mage::getStoreConfig(self::XML_PATH_MSRP_EXPLANATION_MESSAGE, $this->_storeId),
            array('b','br','strong','i','u', 'p', 'span')
        );
    }

    /**
     * Return MAP explanation message for "Whats This" window
     *
     * @return string
     */
    public function getMsrpExplanationMessageWhatsThis()
    {
        return $this->escapeHtml(
            Mage::getStoreConfig(self::XML_PATH_MSRP_EXPLANATION_MESSAGE_WHATS_THIS, $this->_storeId),
            array('b','br','strong','i','u', 'p', 'span')
        );
    }

    /**
     * Check if can apply Minimum Advertise price to post
     * in specific visibility
     *
     * @param int|Mage_Catalog_Model_Post $post
     * @param int $visibility Check displaying price in concrete place (by default generally)
     * @param bool $checkAssociatedItems
     * @return bool
     */
    public function canApplyMsrp($post, $visibility = null, $checkAssociatedItems = true)
    {
        if (!$this->isMsrpEnabled()) {
            return false;
        }

        if (is_numeric($post)) {
            $post = Mage::getModel('catalog/post')
                ->load($post);
        }

        if (!$this->canApplyMsrpToPostType($post)) {
            return false;
        }

        $result = $post->getMsrpEnabled();
        if ($result == Mage_Catalog_Model_Post_Attribute_Source_Msrp_Type_Enabled::MSRP_ENABLE_USE_CONFIG) {
            $result = $this->isMsrpApplyToAll();
        }

        if (!$post->hasMsrpEnabled() && $this->isMsrpApplyToAll()) {
            $result = true;
        }

        if ($result && $visibility !== null) {
            $postVisibility = $post->getMsrpDisplayActualPriceType();
            if ($postVisibility == Mage_Catalog_Model_Post_Attribute_Source_Msrp_Type_Price::TYPE_USE_CONFIG) {
                $postVisibility = $this->getMsrpDisplayActualPriceType();
            }
            $result = ($postVisibility == $visibility);
        }

        if ($post->getTypeInstance(true)->isComposite($post)
            && $checkAssociatedItems
            && (!$result || $visibility !== null)
        ) {
            $resultInOptions = $post->getTypeInstance(true)->isMapEnabledInOptions($post, $visibility);
            if ($resultInOptions !== null) {
                $result = $resultInOptions;
            }
        }

        return $result;
    }

    /**
     * Check whether MAP applied to post Post Type
     *
     * @param Mage_Catalog_Model_Post $post
     * @return bool
     */
    public function canApplyMsrpToPostType($post)
    {
        if($this->_mapApplyToPostType === null) {
            /** @var $attribute Mage_Catalog_Model_Resource_Eav_Attribute */
            $attribute = Mage::getModel('catalog/resource_eav_attribute')
                ->loadByCode(Mage_Catalog_Model_Post::ENTITY, 'msrp_enabled');
            $this->_mapApplyToPostType = $attribute->getApplyTo();
        }
        return empty($this->_mapApplyToPostType) || in_array($post->getTypeId(), $this->_mapApplyToPostType);
    }

    /**
     * Get MAP message for price
     *
     * @param Mage_Catalog_Model_Post $post
     * @return string
     */
    public function getMsrpPriceMessage($post)
    {
        $message = "";
        if ($this->canApplyMsrp(
            $post,
            Mage_Catalog_Model_Post_Attribute_Source_Msrp_Type::TYPE_IN_CART
        )) {
            $message = $this->__('To see post price, add this item to your cart. You can always remove it later.');
        } elseif ($this->canApplyMsrp(
            $post,
            Mage_Catalog_Model_Post_Attribute_Source_Msrp_Type::TYPE_BEFORE_ORDER_CONFIRM
        )) {
            $message = $this->__('See price before order confirmation.');
        }
        return $message;
    }

    /**
     * Check is post need gesture to show price
     *
     * @param Mage_Catalog_Model_Post $post
     * @return bool
     */
    public function isShowPriceOnGesture($post)
    {
        return $this->canApplyMsrp(
            $post,
            Mage_Catalog_Model_Post_Attribute_Source_Msrp_Type::TYPE_ON_GESTURE
        );
    }

    /**
     * Whether to display items count for each filter option
     * @param int $storeId Store view ID
     * @return bool
     */
    public function shouldDisplayPostCountOnLayer($storeId = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_DISPLAY_PRODUCT_COUNT, $storeId);
    }
}

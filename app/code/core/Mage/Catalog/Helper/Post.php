<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog category helper
 *
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Helper_Post extends Mage_Core_Helper_Url
{
    const XML_PATH_PRODUCT_URL_SUFFIX           = 'catalog/seo/post_url_suffix';
    const XML_PATH_PRODUCT_URL_USE_CATEGORY     = 'catalog/seo/post_use_categories';
    const XML_PATH_USE_PRODUCT_CANONICAL_TAG    = 'catalog/seo/post_canonical_tag';

    /**
     * Flag that shows if Magento has to check post to be saleable (enabled and/or inStock)
     *
     * @var boolean
     */
    protected $_skipSaleableCheck = false;

    /**
     * Cache for post rewrite suffix
     *
     * @var array
     */
    protected $_postUrlSuffix = array();

    protected $_statuses;

    protected $_priceBlock;

    /**
     * Retrieve post view page url
     *
     * @param   mixed $post
     * @return  string
     */
    public function getPostUrl($post)
    {
        if ($post instanceof Mage_Catalog_Model_Post) {
            return $post->getPostUrl();
        }
        elseif (is_numeric($post)) {
            return Mage::getModel('catalog/post')->load($post)->getPostUrl();
        }
        return false;
    }

    /**
     * Retrieve post view page url including provided category Id
     *
     * @param   int $postId
     * @param   int $categoryId
     * @return  string
     */
    public function getFullPostUrl($postId, $categoryId = null)
    {
        $post = Mage::getModel('catalog/post')->load($postId);
        if ($categoryId && $post->canBeShowInCategory($categoryId)) {
            $category = Mage::getModel('catalog/category')->load($categoryId);
            $post->setCategory($category);
        }
        return $post->getPostUrl();
    }

    /**
     * Retrieve post price
     *
     * @param   Mage_Catalog_Model_Post $post
     * @return  float
     */
    public function getPrice($post)
    {
        return $post->getPrice();
    }

    /**
     * Retrieve post final price
     *
     * @param   Mage_Catalog_Model_Post $post
     * @return  float
     */
    public function getFinalPrice($post)
    {
        return $post->getFinalPrice();
    }

    /**
     * Retrieve base image url
     *
     * @return string
     */
    public function getImageUrl($post)
    {
        $url = false;
        if (!$post->getImage()) {
            $url = Mage::getDesign()->getSkinUrl('images/no_image.jpg');
        }
        elseif ($attribute = $post->getResource()->getAttribute('image')) {
            $url = $attribute->getFrontend()->getUrl($post);
        }
        return $url;
    }

    /**
     * Retrieve small image url
     *
     * @return unknown
     */
    public function getSmallImageUrl($post)
    {
        $url = false;
        if (!$post->getSmallImage()) {
            $url = Mage::getDesign()->getSkinUrl('images/no_image.jpg');
        }
        elseif ($attribute = $post->getResource()->getAttribute('small_image')) {
            $url = $attribute->getFrontend()->getUrl($post);
        }
        return $url;
    }

    /**
     * Retrieve thumbnail image url
     *
     * @return unknown
     */
    public function getThumbnailUrl($post)
    {
        return '';
    }

    public function getEmailToFriendUrl($post)
    {
        $categoryId = null;
        if ($category = Mage::registry('current_category')) {
            $categoryId = $category->getId();
        }
        return $this->_getUrl('sendfriend/post/send', array(
            'id' => $post->getId(),
            'cat_id' => $categoryId
        ));
    }

    public function getStatuses()
    {
        if(is_null($this->_statuses)) {
            $this->_statuses = array();//Mage::getModel('catalog/post_status')->getResourceCollection()->load();
        }

        return $this->_statuses;
    }

    /**
     * Check if a post can be shown
     *
     * @param  Mage_Catalog_Model_Post|int $post
     * @return boolean
     */
    public function canShow($post, $where = 'catalog')
    {
        if (is_int($post)) {
            $post = Mage::getModel('catalog/post')->load($post);
        }

        /* @var $post Mage_Catalog_Model_Post */

        if (!$post->getId()) {
            return false;
        }

        return true;
    }

    /**
     * Retrieve post rewrite sufix for store
     *
     * @param int $storeId
     * @return string
     */
    public function getPostUrlSuffix($storeId = null)
    {
        if (is_null($storeId)) {
            $storeId = Mage::app()->getStore()->getId();
        }

        if (!isset($this->_postUrlSuffix[$storeId])) {
            $this->_postUrlSuffix[$storeId] = Mage::getStoreConfig(self::XML_PATH_PRODUCT_URL_SUFFIX, $storeId);
        }
        return $this->_postUrlSuffix[$storeId];
    }

    /**
     * Check if <link rel="canonical"> can be used for post
     *
     * @param $store
     * @return bool
     */
    public function canUseCanonicalTag($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_USE_PRODUCT_CANONICAL_TAG, $store);
    }

    /**
     * Return information array of post attribute input types
     * Only a small number of settings returned, so we won't break anything in current dataflow
     * As soon as development process goes on we need to add there all possible settings
     *
     * @param string $inputType
     * @return array
     */
    public function getAttributeInputTypes($inputType = null)
    {
        /**
        * @todo specify there all relations for properties depending on input type
        */
        $inputTypes = array(
            'multiselect'   => array(
                'backend_model'     => 'eav/entity_attribute_backend_array'
            ),
            'boolean'       => array(
                'source_model'      => 'eav/entity_attribute_source_boolean'
            )
        );

        if (is_null($inputType)) {
            return $inputTypes;
        } else if (isset($inputTypes[$inputType])) {
            return $inputTypes[$inputType];
        }
        return array();
    }

    /**
     * Return default attribute backend model by input type
     *
     * @param string $inputType
     * @return string|null
     */
    public function getAttributeBackendModelByInputType($inputType)
    {
        $inputTypes = $this->getAttributeInputTypes();
        if (!empty($inputTypes[$inputType]['backend_model'])) {
            return $inputTypes[$inputType]['backend_model'];
        }
        return null;
    }

    /**
     * Return default attribute source model by input type
     *
     * @param string $inputType
     * @return string|null
     */
    public function getAttributeSourceModelByInputType($inputType)
    {
        $inputTypes = $this->getAttributeInputTypes();
        if (!empty($inputTypes[$inputType]['source_model'])) {
            return $inputTypes[$inputType]['source_model'];
        }
        return null;
    }

    /**
     * Inits post to be used for post controller actions and layouts
     * $params can have following data:
     *   'category_id' - id of category to check and append to post as current.
     *     If empty (except FALSE) - will be guessed (e.g. from last visited) to load as current.
     *
     * @param int $postId
     * @param Mage_Core_Controller_Front_Action $controller
     * @param Varien_Object $params
     *
     * @return false|Mage_Catalog_Model_Post
     */
    public function initPost($postId, $controller, $params = null)
    {
        // Prepare data for routine
        if (!$params) {
            $params = new Varien_Object();
        }

        // Init and load post
        Mage::dispatchEvent('catalog_controller_post_init_before', array(
            'controller_action' => $controller,
            'params' => $params,
        ));

        if (!$postId) {
            return false;
        }

        $post = Mage::getModel('catalog/post')
            ->load($postId);

        if (!$this->canShow($post)) {
            return false;
        }


        // Load post current category
        $categoryId = $params->getCategoryId();
        if (!$categoryId && ($categoryId !== false)) {
            $lastId = Mage::getSingleton('catalog/session')->getLastVisitedCategoryId();
           
            $categoryId = $lastId;
            
        }
        if ($categoryId) {
            $category = Mage::getModel('catalog/category')->load($categoryId);
            $post->setCategory($category);
            Mage::register('current_category', $category);
        }

        // Register current data and dispatch final events
        Mage::register('current_post', $post);
        Mage::register('post', $post);

        try {
            Mage::dispatchEvent('catalog_controller_post_init', array('post' => $post));
            Mage::dispatchEvent('catalog_controller_post_init_after',
                            array('post' => $post,
                                'controller_action' => $controller
                            )
            );
        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            return false;
        }

        return $post;
    }

    /**
     * Prepares post options by buyRequest: retrieves values and assigns them as default.
     * Also parses and adds post management related values - e.g. qty
     *
     * @param  Mage_Catalog_Model_Post $post
     * @param  Varien_Object $buyRequest
     * @return Mage_Catalog_Helper_Post
     */
    public function preparePostOptions($post, $buyRequest)
    {
        $optionValues = $post->processBuyRequest($buyRequest);
        $optionValues->setQty($buyRequest->getQty());
        $post->setPreconfiguredValues($optionValues);

        return $this;
    }

    /**
     * Process $buyRequest and sets its options before saving configuration to some post item.
     * This method is used to attach additional parameters to processed buyRequest.
     *
     * $params holds parameters of what operation must be performed:
     * - 'current_config', Varien_Object or array - current buyRequest that configures post in this item,
     *   used to restore currently attached files
     * - 'files_prefix': string[a-z0-9_] - prefix that was added at frontend to names of file inputs,
     *   so they won't intersect with other submitted options
     *
     * @param Varien_Object|array $buyRequest
     * @param Varien_Object|array $params
     * @return Varien_Object
     */
    public function addParamsToBuyRequest($buyRequest, $params)
    {
        if (is_array($buyRequest)) {
            $buyRequest = new Varien_Object($buyRequest);
        }
        if (is_array($params)) {
            $params = new Varien_Object($params);
        }


        // Ensure that currentConfig goes as Varien_Object - for easier work with it later
        $currentConfig = $params->getCurrentConfig();
        if ($currentConfig) {
            if (is_array($currentConfig)) {
                $params->setCurrentConfig(new Varien_Object($currentConfig));
            } else if (!($currentConfig instanceof Varien_Object)) {
                $params->unsCurrentConfig();
            }
        }

        /*
         * Notice that '_processing_params' must always be object to protect processing forged requests
         * where '_processing_params' comes in $buyRequest as array from user input
         */
        $processingParams = $buyRequest->getData('_processing_params');
        if (!$processingParams || !($processingParams instanceof Varien_Object)) {
            $processingParams = new Varien_Object();
            $buyRequest->setData('_processing_params', $processingParams);
        }
        $processingParams->addData($params->getData());

        return $buyRequest;
    }

    /**
     * Return loaded post instance
     *
     * @param  int|string $postId (SKU or ID)
     * @param  int $store
     * @param  string $identifierType
     * @return Mage_Catalog_Model_Post
     */
    public function getPost($postId, $store, $identifierType = null)
    {
        /** @var $post Mage_Catalog_Model_Post */
        $post = Mage::getModel('catalog/post');

        $expectedIdType = false;
        if ($identifierType === null) {
            if (is_string($postId) && !preg_match("/^[+-]?[1-9][0-9]*$|^0$/", $postId)) {
                $expectedIdType = 'sku';
            }
        }

        if ($identifierType == 'sku' || $expectedIdType == 'sku') {
            $idBySku = $post->getIdBySku($postId);
            if ($idBySku) {
                $postId = $idBySku;
            } else if ($identifierType == 'sku') {
                // Return empty post because it was not found by originally specified SKU identifier
                return $post;
            }
        }

        if ($postId && is_numeric($postId)) {
            $post->load((int) $postId);
        }

        return $post;
    }

    /**
     * Set flag that shows if Magento has to check post to be saleable (enabled and/or inStock)
     *
     * For instance, during order creation in the backend admin has ability to add any posts to order
     *
     * @param bool $skipSaleableCheck
     * @return Mage_Catalog_Helper_Post
     */
    public function setSkipSaleableCheck($skipSaleableCheck = false)
    {
        $this->_skipSaleableCheck = $skipSaleableCheck;
        return $this;
    }

    /**
     * Get flag that shows if Magento has to check post to be saleable (enabled and/or inStock)
     *
     * @return boolean
     */
    public function getSkipSaleableCheck()
    {
        return $this->_skipSaleableCheck;
    }
}

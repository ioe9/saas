<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog url model
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Model_Url
{
    /**
     * Number of characters allowed to be in URL path
     *
     * @var int
     */
    const MAX_REQUEST_PATH_LENGTH = 240;

    /**
     * Number of characters allowed to be in URL path
     * after MAX_REQUEST_PATH_LENGTH number of characters
     *
     * @var int
     */
    const ALLOWED_REQUEST_PATH_OVERFLOW = 10;

    /**
     * Resource model
     *
     * @var Mage_Catalog_Model_Resource_Eav_Mysql4_Url
     */
    protected $_resourceModel;

    /**
     * Categories cache for posts
     *
     * @var array
     */
    protected $_categories = array();

    /**
     * Store root categories cache
     *
     * @var array
     */
    protected $_rootCategories = array();

    /**
     * Rewrite cache
     *
     * @var array
     */
    protected $_rewrites = array();

    /**
     * Current url rewrite rule
     *
     * @var Varien_Object
     */
    protected $_rewrite;

    /**
     * Cache for post rewrite suffix
     *
     * @var array
     */
    protected $_postUrlSuffix = array();

    /**
     * Cache for category rewrite suffix
     *
     * @var array
     */
    protected $_categoryUrlSuffix = array();

    /**
     * Flag to overwrite config settings for Catalog URL rewrites history maintainance
     *
     * @var bool
     */
    protected $_saveRewritesHistory = null;

     /**
     * Singleton of category model for building URL path
     *
     * @var Mage_Catalog_Model_Category
     */
    static protected $_categoryForUrlPath;

    /**
     * Adds url_path property for non-root category - to ensure that url path is not empty.
     *
     * Sometimes attribute 'url_path' can be empty, because url_path hasn't been generated yet,
     * in this case category is loaded with empty url_path and we should generate it manually.
     *
     * @param Varien_Object $category
     * @return void
     */
    protected function _addCategoryUrlPath($category)
    {
        if (!($category instanceof Varien_Object) || $category->getUrlPath()) {
            return;
        }

        // This routine is not intended to be used with root categories,
        // but handle 'em gracefully - ensure them to have empty path.
        if ($category->getLevel() <= 1) {
            $category->setUrlPath('');
            return;
        }

        if (self::$_categoryForUrlPath === null) {
            self::$_categoryForUrlPath = Mage::getModel('catalog/category');
        }

        // Generate url_path
        $urlPath = self::$_categoryForUrlPath
            ->setData($category->getData())
            ->getUrlPath();
        $category->setUrlPath($urlPath);
    }

    /**
     * Retrieve stores array or store model
     *
     * @param int $storeId
     * @return Mage_Core_Model_Store|array
     */
    public function getStores($storeId = null)
    {
        return $this->getResource()->getStores($storeId);
    }

    /**
     * Retrieve resource model
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Url
     */
    public function getResource()
    {
        if (is_null($this->_resourceModel)) {
            $this->_resourceModel = Mage::getResourceModel('catalog/url');
        }
        return $this->_resourceModel;
    }

    /**
     * Retrieve Category model singleton
     *
     * @return Mage_Catalog_Model_Category
     */
    public function getCategoryModel()
    {
        return $this->getResource()->getCategoryModel();
    }

    /**
     * Retrieve post model singleton
     *
     * @return Mage_Catalog_Model_Post
     */
    public function getPostModel()
    {
        return $this->getResource()->getPostModel();
    }

    /**
     * Setter for $_saveRewritesHistory
     * Force Rewrites History save bypass config settings
     *
     * @param bool $flag
     * @return Mage_Catalog_Model_Url
     */
    public function setShouldSaveRewritesHistory($flag)
    {
        $this->_saveRewritesHistory = (bool)$flag;
        return $this;
    }

    /**
     * Indicate whether to save URL Rewrite History or not (create redirects to old URLs)
     *
     * @param int $storeId Store View
     * @return bool
     */
    public function getShouldSaveRewritesHistory($storeId = null)
    {
        if ($this->_saveRewritesHistory !== null) {
            return $this->_saveRewritesHistory;
        }
        return Mage::helper('catalog')->shouldSaveUrlRewritesHistory($storeId);
    }

    /**
     * Refresh all rewrite urls for some store or for all stores
     * Used to make full reindexing of url rewrites
     *
     * @param int $storeId
     * @return Mage_Catalog_Model_Url
     */
    public function refreshRewrites($storeId = null)
    {
        if (is_null($storeId)) {
            foreach ($this->getStores() as $store) {
                $this->refreshRewrites($store->getId());
            }
            return $this;
        }

        $this->clearStoreInvalidRewrites($storeId);
        $this->refreshCategoryRewrite(Mage_Catalog_Model_Category::TREE_DEFAULT_ID, $storeId, false);
        $this->refreshPostRewrites($storeId);
        $this->getResource()->clearCategoryPost($storeId);

        return $this;
    }

    /**
     * Refresh category rewrite
     *
     * @param Varien_Object $category
     * @param string $parentPath
     * @param bool $refreshPosts
     * @return Mage_Catalog_Model_Url
     */
    protected function _refreshCategoryRewrites(Varien_Object $category, $parentPath = null, $refreshPosts = true)
    {
        if ($category->getId() != $this->getStores($category->getStoreId())->getRootCategoryId()) {
            if ($category->getUrlKey() == '') {
                $urlKey = $this->getCategoryModel()->formatUrlKey($category->getName());
            }
            else {
                $urlKey = $this->getCategoryModel()->formatUrlKey($category->getUrlKey());
            }

            $idPath      = $this->generatePath('id', null, $category);
            $targetPath  = $this->generatePath('target', null, $category);
            $requestPath = $this->getCategoryRequestPath($category, $parentPath);

            $rewriteData = array(
                'store_id'      => $category->getStoreId(),
                'category_id'   => $category->getId(),
                'post_id'    => null,
                'id_path'       => $idPath,
                'request_path'  => $requestPath,
                'target_path'   => $targetPath,
                'is_system'     => 1
            );

            $this->getResource()->saveRewrite($rewriteData, $this->_rewrite);

            if ($this->getShouldSaveRewritesHistory($category->getStoreId())) {
                $this->_saveRewriteHistory($rewriteData, $this->_rewrite);
            }

            if ($category->getUrlKey() != $urlKey) {
                $category->setUrlKey($urlKey);
                $this->getResource()->saveCategoryAttribute($category, 'url_key');
            }
            if ($category->getUrlPath() != $requestPath) {
                $category->setUrlPath($requestPath);
                $this->getResource()->saveCategoryAttribute($category, 'url_path');
            }
        }
        else {
            if ($category->getUrlPath() != '') {
                $category->setUrlPath('');
                $this->getResource()->saveCategoryAttribute($category, 'url_path');
            }
        }

        if ($refreshPosts) {
            $this->_refreshCategoryPostRewrites($category);
        }

        foreach ($category->getChilds() as $child) {
            $this->_refreshCategoryRewrites($child, $category->getUrlPath() . '/', $refreshPosts);
        }

        return $this;
    }

    /**
     * Refresh post rewrite
     *
     * @param Varien_Object $post
     * @param Varien_Object $category
     * @return Mage_Catalog_Model_Url
     */
    protected function _refreshPostRewrite(Varien_Object $post, Varien_Object $category)
    {
        if ($category->getId() == $category->getPath()) {
            return $this;
        }
        if ($post->getUrlKey() == '') {
            $urlKey = $this->getPostModel()->formatUrlKey($post->getName());
        }
        else {
            $urlKey = $this->getPostModel()->formatUrlKey($post->getUrlKey());
        }

        $idPath      = $this->generatePath('id', $post, $category);
        $targetPath  = $this->generatePath('target', $post, $category);
        $requestPath = $this->getPostRequestPath($post, $category);

        $categoryId = null;
        $updateKeys = true;
        if ($category->getLevel() > 1) {
            $categoryId = $category->getId();
            $updateKeys = false;
        }

        $rewriteData = array(
            'store_id'      => $category->getStoreId(),
            'category_id'   => $categoryId,
            'post_id'    => $post->getId(),
            'id_path'       => $idPath,
            'request_path'  => $requestPath,
            'target_path'   => $targetPath,
            'is_system'     => 1
        );

        $this->getResource()->saveRewrite($rewriteData, $this->_rewrite);

        if ($this->getShouldSaveRewritesHistory($category->getStoreId())) {
            $this->_saveRewriteHistory($rewriteData, $this->_rewrite);
        }

        if ($updateKeys && $post->getUrlKey() != $urlKey) {
            $post->setUrlKey($urlKey);
            $this->getResource()->savePostAttribute($post, 'url_key');
        }
        if ($updateKeys && $post->getUrlPath() != $requestPath) {
            $post->setUrlPath($requestPath);
            $this->getResource()->savePostAttribute($post, 'url_path');
        }

        return $this;
    }

    /**
     * Refresh posts for catwgory
     *
     * @param Varien_Object $category
     * @return Mage_Catalog_Model_Url
     */
    protected function _refreshCategoryPostRewrites(Varien_Object $category)
    {
        $originalRewrites = $this->_rewrites;
        $process = true;
        $lastEntityId = 0;
        $firstIteration = true;
        while ($process == true) {
            $posts = $this->getResource()->getPostsByCategory($category, $lastEntityId);
            if (!$posts) {
                if ($firstIteration) {
                    $this->getResource()->deleteCategoryPostStoreRewrites(
                        $category->getId(),
                        array(),
                        $category->getStoreId()
                    );
                }
                $process = false;
                break;
            }

            // Prepare rewrites for generation
            $rootCategory = $this->getStoreRootCategory($category->getStoreId());
            $categoryIds = array($category->getId(), $rootCategory->getId());
            $this->_rewrites = $this->getResource()->prepareRewrites(
                $category->getStoreId(),
                $categoryIds,
                array_keys($posts)
            );

            foreach ($posts as $post) {
                // Post always must have rewrite in root category
                $this->_refreshPostRewrite($post, $rootCategory);
                $this->_refreshPostRewrite($post, $category);
            }
            $firstIteration = false;
            unset($posts);
        }
        $this->_rewrites = $originalRewrites;
        return $this;
    }

    /**
     * Refresh category and childs rewrites
     * Called when reindexing all rewrites and as a reaction on category change that affects rewrites
     *
     * @param int $categoryId
     * @param int|null $storeId
     * @param bool $refreshPosts
     * @return Mage_Catalog_Model_Url
     */
    public function refreshCategoryRewrite($categoryId, $storeId = null, $refreshPosts = true)
    {
        if (is_null($storeId)) {
            foreach ($this->getStores() as $store) {
                $this->refreshCategoryRewrite($categoryId, $store->getId(), $refreshPosts);
            }
            return $this;
        }

        $category = $this->getResource()->getCategory($categoryId, $storeId);
        if (!$category) {
            return $this;
        }

        // Load all childs and refresh all categories
        $category = $this->getResource()->loadCategoryChilds($category);
        $categoryIds = array($category->getId());
        if ($category->getAllChilds()) {
            $categoryIds = array_merge($categoryIds, array_keys($category->getAllChilds()));
        }
        $this->_rewrites = $this->getResource()->prepareRewrites($storeId, $categoryIds);
        $this->_refreshCategoryRewrites($category, null, $refreshPosts);

        unset($category);
        $this->_rewrites = array();

        return $this;
    }

    /**
     * Refresh post rewrite urls for one store or all stores
     * Called as a reaction on post change that affects rewrites
     *
     * @param int $postId
     * @param int|null $storeId
     * @return Mage_Catalog_Model_Url
     */
    public function refreshPostRewrite($postId, $storeId = null)
    {
        if (is_null($storeId)) {
            foreach ($this->getStores() as $store) {
                $this->refreshPostRewrite($postId, $store->getId());
            }
            return $this;
        }

        $post = $this->getResource()->getPost($postId, $storeId);
        if ($post) {
            $store = $this->getStores($storeId);
            $storeRootCategoryId = $store->getRootCategoryId();

            // List of categories the post is assigned to, filtered by being within the store's categories root
            $categories = $this->getResource()->getCategories($post->getCategoryIds(), $storeId);
            $this->_rewrites = $this->getResource()->prepareRewrites($storeId, '', $postId);

            // Add rewrites for all needed categories
            // If post is assigned to any of store's categories -
            // we also should use store root category to create root post url rewrite
            if (!isset($categories[$storeRootCategoryId])) {
                $categories[$storeRootCategoryId] = $this->getResource()->getCategory($storeRootCategoryId, $storeId);
            }

            // Create post url rewrites
            foreach ($categories as $category) {
                $this->_refreshPostRewrite($post, $category);
            }

            // Remove all other post rewrites created earlier for this store - they're invalid now
            $excludeCategoryIds = array_keys($categories);
            $this->getResource()->clearPostRewrites($postId, $storeId, $excludeCategoryIds);

            unset($categories);
            unset($post);
        } else {
            // Post doesn't belong to this store - clear all its url rewrites including root one
            $this->getResource()->clearPostRewrites($postId, $storeId, array());
        }

        return $this;
    }

    /**
     * Refresh all post rewrites for designated store
     *
     * @param int $storeId
     * @return Mage_Catalog_Model_Url
     */
    public function refreshPostRewrites($storeId)
    {
        $this->_categories      = array();
        $storeRootCategoryId    = $this->getStores($storeId)->getRootCategoryId();
        $storeRootCategoryPath  = $this->getStores($storeId)->getRootCategoryPath();
        $this->_categories[$storeRootCategoryId] = $this->getResource()->getCategory($storeRootCategoryId, $storeId);

        $lastEntityId = 0;
        $process = true;

        while ($process == true) {
            $posts = $this->getResource()->getPostsByStore($storeId, $lastEntityId);
            if (!$posts) {
                $process = false;
                break;
            }

            $this->_rewrites = $this->getResource()->prepareRewrites($storeId, false, array_keys($posts));

            $loadCategories = array();
            foreach ($posts as $post) {
                foreach ($post->getCategoryIds() as $categoryId) {
                    if (!isset($this->_categories[$categoryId])) {
                        $loadCategories[$categoryId] = $categoryId;
                    }
                }
            }

            if ($loadCategories) {
                foreach ($this->getResource()->getCategories($loadCategories, $storeId) as $category) {
                    $this->_categories[$category->getId()] = $category;
                }
            }

            foreach ($posts as $post) {
                $this->_refreshPostRewrite($post, $this->_categories[$storeRootCategoryId]);
                foreach ($post->getCategoryIds() as $categoryId) {
                    if ($categoryId != $storeRootCategoryId && isset($this->_categories[$categoryId])) {
                        if (strpos($this->_categories[$categoryId]['path'], $storeRootCategoryPath . '/') !== 0) {
                            continue;
                        }
                        $this->_refreshPostRewrite($post, $this->_categories[$categoryId]);
                    }
                }
            }

            unset($posts);
            $this->_rewrites = array();
        }

        $this->_categories = array();
        return $this;
    }

    /**
     * Deletes old rewrites for store, left from the times when store had some other root category
     *
     * @param int $storeId
     * @return Mage_Catalog_Model_Url
     */
    public function clearStoreInvalidRewrites($storeId = null)
    {
        if (is_null($storeId)) {
            foreach ($this->getStores() as $store) {
                $this->clearStoreInvalidRewrites($store->getId());
            }
            return $this;
        }

        $this->getResource()->clearStoreInvalidRewrites($storeId);
        return $this;
    }

    /**
     * Get requestPath that was not used yet.
     *
     * Will try to get unique path by adding -1 -2 etc. between url_key and optional url_suffix
     *
     * @param int $storeId
     * @param string $requestPath
     * @param string $idPath
     * @return string
     */
    public function getUnusedPath($storeId, $requestPath, $idPath)
    {
        if (strpos($idPath, 'post') !== false) {
            $suffix = $this->getPostUrlSuffix($storeId);
        } else {
            $suffix = $this->getCategoryUrlSuffix($storeId);
        }
        if (empty($requestPath)) {
            $requestPath = '-';
        } elseif ($requestPath == $suffix) {
            $requestPath = '-' . $suffix;
        }

        /**
         * Validate maximum length of request path
         */
        if (strlen($requestPath) > self::MAX_REQUEST_PATH_LENGTH + self::ALLOWED_REQUEST_PATH_OVERFLOW) {
            $requestPath = substr($requestPath, 0, self::MAX_REQUEST_PATH_LENGTH);
        }

        if (isset($this->_rewrites[$idPath])) {
            $this->_rewrite = $this->_rewrites[$idPath];
            if ($this->_rewrites[$idPath]->getRequestPath() == $requestPath) {
                return $requestPath;
            }
        }
        else {
            $this->_rewrite = null;
        }

        $rewrite = $this->getResource()->getRewriteByRequestPath($requestPath, $storeId);
        if ($rewrite && $rewrite->getId()) {
            if ($rewrite->getIdPath() == $idPath) {
                $this->_rewrite = $rewrite;
                return $requestPath;
            }
            // match request_url abcdef1234(-12)(.html) pattern
            $match = array();
            $regularExpression = '#^([0-9a-z/-]+?)(-([0-9]+))?('.preg_quote($suffix).')?$#i';
            if (!preg_match($regularExpression, $requestPath, $match)) {
                return $this->getUnusedPath($storeId, '-', $idPath);
            }
            $match[1] = $match[1] . '-';
            $match[4] = isset($match[4]) ? $match[4] : '';

            $lastRequestPath = $this->getResource()
                ->getLastUsedRewriteRequestIncrement($match[1], $match[4], $storeId);
            if ($lastRequestPath) {
                $match[3] = $lastRequestPath;
            }
            return $match[1]
                . (isset($match[3]) ? ($match[3]+1) : '1')
                . $match[4];
        }
        else {
            return $requestPath;
        }
    }

    /**
     * Retrieve post rewrite sufix for store
     *
     * @param int $storeId
     * @return string
     */
    public function getPostUrlSuffix($storeId)
    {
        return Mage::helper('catalog/post')->getPostUrlSuffix($storeId);
    }

    /**
     * Retrieve category rewrite sufix for store
     *
     * @param int $storeId
     * @return string
     */
    public function getCategoryUrlSuffix($storeId)
    {
        return Mage::helper('catalog/category')->getCategoryUrlSuffix($storeId);
    }

    /**
     * Get unique category request path
     *
     * @param Varien_Object $category
     * @param string $parentPath
     * @return string
     */
    public function getCategoryRequestPath($category, $parentPath)
    {
        $storeId = $category->getStoreId();
        $idPath  = $this->generatePath('id', null, $category);
        $suffix  = $this->getCategoryUrlSuffix($storeId);

        if (isset($this->_rewrites[$idPath])) {
            $this->_rewrite = $this->_rewrites[$idPath];
            $existingRequestPath = $this->_rewrites[$idPath]->getRequestPath();
        }

        if ($category->getUrlKey() == '') {
            $urlKey = $this->getCategoryModel()->formatUrlKey($category->getName());
        }
        else {
            $urlKey = $this->getCategoryModel()->formatUrlKey($category->getUrlKey());
        }

        $categoryUrlSuffix = $this->getCategoryUrlSuffix($category->getStoreId());
        if (null === $parentPath) {
            $parentPath = $this->getResource()->getCategoryParentPath($category);
        }
        elseif ($parentPath == '/') {
            $parentPath = '';
        }
        $parentPath = Mage::helper('catalog/category')->getCategoryUrlPath($parentPath,
                                                                           true, $category->getStoreId());

        $requestPath = $parentPath . $urlKey . $categoryUrlSuffix;
        if (isset($existingRequestPath) && $existingRequestPath == $requestPath . $suffix) {
            return $existingRequestPath;
        }

        if ($this->_deleteOldTargetPath($requestPath, $idPath, $storeId)) {
            return $requestPath;
        }

        return $this->getUnusedPath($category->getStoreId(), $requestPath,
                                    $this->generatePath('id', null, $category)
        );
    }

    /**
     * Check if current generated request path is one of the old paths
     *
     * @param string $requestPath
     * @param string $idPath
     * @param int $storeId
     * @return bool
     */
    protected function _deleteOldTargetPath($requestPath, $idPath, $storeId)
    {
        $finalOldTargetPath = $this->getResource()->findFinalTargetPath($requestPath, $storeId);
        if ($finalOldTargetPath && $finalOldTargetPath == $idPath) {
            $this->getResource()->deleteRewriteRecord($requestPath, $storeId, true);
            return true;
        }

        return false;
    }

    /**
     * Get unique post request path
     *
     * @param   Varien_Object $post
     * @param   Varien_Object $category
     * @return  string
     */
    public function getPostRequestPath($post, $category)
    {
        if ($post->getUrlKey() == '') {
            $urlKey = $this->getPostModel()->formatUrlKey($post->getName());
        } else {
            $urlKey = $this->getPostModel()->formatUrlKey($post->getUrlKey());
        }
        $storeId = $category->getStoreId();
        $suffix  = $this->getPostUrlSuffix($storeId);
        $idPath  = $this->generatePath('id', $post, $category);
        /**
         * Prepare post base request path
         */
        if ($category->getLevel() > 1) {
            // To ensure, that category has path either from attribute or generated now
            $this->_addCategoryUrlPath($category);
            $categoryUrl = Mage::helper('catalog/category')->getCategoryUrlPath($category->getUrlPath(),
                false, $storeId);
            $requestPath = $categoryUrl . '/' . $urlKey;
        } else {
            $requestPath = $urlKey;
        }

        if (strlen($requestPath) > self::MAX_REQUEST_PATH_LENGTH + self::ALLOWED_REQUEST_PATH_OVERFLOW) {
            $requestPath = substr($requestPath, 0, self::MAX_REQUEST_PATH_LENGTH);
        }

        $this->_rewrite = null;
        /**
         * Check $requestPath should be unique
         */
        if (isset($this->_rewrites[$idPath])) {
            $this->_rewrite = $this->_rewrites[$idPath];
            $existingRequestPath = $this->_rewrites[$idPath]->getRequestPath();

            if ($existingRequestPath == $requestPath . $suffix) {
                return $existingRequestPath;
            }

            $existingRequestPath = preg_replace('/' . preg_quote($suffix, '/') . '$/', '', $existingRequestPath);
            /**
             * Check if existing request past can be used
             */
            if ($post->getUrlKey() == '' && !empty($requestPath)
                && strpos($existingRequestPath, $requestPath) === 0
            ) {
                $existingRequestPath = preg_replace(
                    '/^' . preg_quote($requestPath, '/') . '/', '', $existingRequestPath
                );
                if (preg_match('#^-([0-9]+)$#i', $existingRequestPath)) {
                    return $this->_rewrites[$idPath]->getRequestPath();
                }
            }

            $fullPath = $requestPath.$suffix;
            if ($this->_deleteOldTargetPath($fullPath, $idPath, $storeId)) {
                return $fullPath;
            }
        }
        /**
         * Check 2 variants: $requestPath and $requestPath . '-' . $postId
         */
        $validatedPath = $this->getResource()->checkRequestPaths(
            array($requestPath.$suffix, $requestPath.'-'.$post->getId().$suffix),
            $storeId
        );

        if ($validatedPath) {
            return $validatedPath;
        }
        /**
         * Use unique path generator
         */
        return $this->getUnusedPath($storeId, $requestPath.$suffix, $idPath);
    }

    /**
     * Generate either id path, request path or target path for post and/or category
     *
     * For generating id or system path, either post or category is required
     * For generating request path - category is required
     * $parentPath used only for generating category path
     *
     * @param string $type
     * @param Varien_Object $post
     * @param Varien_Object $category
     * @param string $parentPath
     * @return string
     * @throws Mage_Core_Exception
     */
    public function generatePath($type = 'target', $post = null, $category = null, $parentPath = null)
    {
        if (!$post && !$category) {
            Mage::throwException(Mage::helper('core')->__('Please specify either a category or a post, or both.'));
        }

        // generate id_path
        if ('id' === $type) {
            if (!$post) {
                return 'category/' . $category->getId();
            }
            if ($category && $category->getLevel() > 1) {
                return 'post/' . $post->getId() . '/' . $category->getId();
            }
            return 'post/' . $post->getId();
        }

        // generate request_path
        if ('request' === $type) {
            // for category
            if (!$post) {
                if ($category->getUrlKey() == '') {
                    $urlKey = $this->getCategoryModel()->formatUrlKey($category->getName());
                }
                else {
                    $urlKey = $this->getCategoryModel()->formatUrlKey($category->getUrlKey());
                }

                $categoryUrlSuffix = $this->getCategoryUrlSuffix($category->getStoreId());
                if (null === $parentPath) {
                    $parentPath = $this->getResource()->getCategoryParentPath($category);
                }
                elseif ($parentPath == '/') {
                    $parentPath = '';
                }
                $parentPath = Mage::helper('catalog/category')->getCategoryUrlPath($parentPath,
                    true, $category->getStoreId());

                return $this->getUnusedPath($category->getStoreId(), $parentPath . $urlKey . $categoryUrlSuffix,
                    $this->generatePath('id', null, $category)
                );
            }

            // for post & category
            if (!$category) {
                Mage::throwException(Mage::helper('core')->__('A category object is required for determining the post request path.')); // why?
            }

            if ($post->getUrlKey() == '') {
                $urlKey = $this->getPostModel()->formatUrlKey($post->getName());
            }
            else {
                $urlKey = $this->getPostModel()->formatUrlKey($post->getUrlKey());
            }
            $postUrlSuffix  = $this->getPostUrlSuffix($category->getStoreId());
            if ($category->getLevel() > 1) {
                // To ensure, that category has url path either from attribute or generated now
                $this->_addCategoryUrlPath($category);
                $categoryUrl = Mage::helper('catalog/category')->getCategoryUrlPath($category->getUrlPath(),
                    false, $category->getStoreId());
                return $this->getUnusedPath($category->getStoreId(), $categoryUrl . '/' . $urlKey . $postUrlSuffix,
                    $this->generatePath('id', $post, $category)
                );
            }

            // for post only
            return $this->getUnusedPath($category->getStoreId(), $urlKey . $postUrlSuffix,
                $this->generatePath('id', $post)
            );
        }

        // generate target_path
        if (!$post) {
            return 'catalog/category/view/id/' . $category->getId();
        }
        if ($category && $category->getLevel() > 1) {
            return 'catalog/post/view/id/' . $post->getId() . '/category/' . $category->getId();
        }
        return 'catalog/post/view/id/' . $post->getId();
    }

    /**
     * Return unique string based on the time in microseconds.
     *
     * @return string
     */
    public function generateUniqueIdPath()
    {
        return str_replace('0.', '', str_replace(' ', '_', microtime()));
    }

    /**
     * Create Custom URL Rewrite for old post/category URL after url_key changed
     * It will perform permanent redirect from old URL to new URL
     *
     * @param array $rewriteData New rewrite data
     * @param Varien_Object $rewrite Rewrite model
     * @return Mage_Catalog_Model_Url
     */
    protected function _saveRewriteHistory($rewriteData, $rewrite)
    {
        if ($rewrite instanceof Varien_Object && $rewrite->getId()) {
            $rewriteData['target_path'] = $rewriteData['request_path'];
            $rewriteData['request_path'] = $rewrite->getRequestPath();
            $rewriteData['id_path'] = $this->generateUniqueIdPath();
            $rewriteData['is_system'] = 0;
            $rewriteData['options'] = 'RP'; // Redirect = Permanent
            $this->getResource()->saveRewriteHistory($rewriteData);
        }

        return $this;
    }
}

<?php
class Mage_Catalog_Model_Factory extends Mage_Core_Model_Factory
{
    /**
     * Xml path to the category url rewrite helper class alias
     */
    const XML_PATH_CATEGORY_URL_REWRITE_HELPER_CLASS = 'catalog/category_url_rewrite';

    /**
     * Xml path to the post url rewrite helper class alias
     */
    const XML_PATH_PRODUCT_URL_REWRITE_HELPER_CLASS = 'catalog/post_url_rewrite';

    /**
     * Path to post_url model alias
     */
    const XML_PATH_PRODUCT_URL_MODEL = 'catalog/post_url';

    /**
     * Path to category_url model alias
     */
    const XML_PATH_CATEGORY_URL_MODEL = 'catalog/category_url';

    /**
     * Returns category url rewrite helper instance
     *
     * @return Mage_Catalog_Helper_Category_Url_Rewrite_Interface
     */
    public function getCategoryUrlRewriteHelper()
    {
        return $this->getHelper(self::XML_PATH_CATEGORY_URL_REWRITE_HELPER_CLASS);
    }

    /**
     * Returns post url rewrite helper instance
     *
     * @return Mage_Catalog_Helper_Post_Url_Rewrite_Interface
     */
    public function getPostUrlRewriteHelper()
    {
        return $this->getHelper(self::XML_PATH_PRODUCT_URL_REWRITE_HELPER_CLASS);
    }

    /**
     * Retrieve post_url instance
     *
     * @return Mage_Catalog_Model_Post_Url
     */
    public function getPostUrlInstance()
    {
        return $this->getModel(self::XML_PATH_PRODUCT_URL_MODEL);
    }

    /**
     * Retrieve category_url instance
     *
     * @return Mage_Catalog_Model_Category_Url
     */
    public function getCategoryUrlInstance()
    {
        return $this->getModel(self::XML_PATH_CATEGORY_URL_MODEL);
    }
}

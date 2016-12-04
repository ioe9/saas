<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog (site)map helper
 */
class Mage_Catalog_Helper_Map extends Mage_Core_Helper_Abstract
{
    CONST XML_PATH_USE_TREE_MODE = 'catalog/sitemap/tree_mode';

    public function getCategoryUrl()
    {
        return $this->_getUrl('catalog/seo_sitemap/category');
    }

    public function getPostUrl()
    {
        return $this->_getUrl('catalog/seo_sitemap/post');
    }

    /**
     * Return true if category tree mode enabled
     *
     * @return boolean
     */
    public function getIsUseCategoryTreeMode()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_USE_TREE_MODE);
    }

}

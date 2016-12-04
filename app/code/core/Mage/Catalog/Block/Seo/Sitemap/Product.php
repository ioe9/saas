<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * SEO Posts Sitemap block
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Block_Seo_Sitemap_Post extends Mage_Catalog_Block_Seo_Sitemap_Abstract
{

    /**
     * Initialize posts collection
     *
     * @return Mage_Catalog_Block_Seo_Sitemap_Category
     */
    protected function _prepareLayout()
    {
        $collection = Mage::getModel('catalog/post')->getCollection();
        /* @var $collection Mage_Catalog_Model_Resource_Eav_Mysql4_Post_Collection */

        $collection->addFieldToSelect('name');
        $collection->addFieldToSelect('url_key');
        $collection->addStoreFilter();

        Mage::getSingleton('catalog/post_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/post_visibility')->addVisibleInCatalogFilterToCollection($collection);

        $this->setCollection($collection);

        return $this;
    }

    /**
     * Get item URL
     *
     * @param Mage_Catalog_Model_Post $category
     * @return string
     */
    public function getItemUrl($post)
    {
        $helper = Mage::helper('catalog/post');
        /* @var $helper Mage_Catalog_Helper_Post */
        return $helper->getPostUrl($post);
    }

}

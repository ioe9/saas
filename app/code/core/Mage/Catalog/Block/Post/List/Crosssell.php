<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Catalog post related items block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Mio Core Team <developer@ioe9.com>
 */

class Mage_Catalog_Block_Post_List_Crosssell extends Mage_Catalog_Block_Post_Abstract
{
    /**
     * Default MAP renderer type
     *
     * @var string
     */
    protected $_mapRenderer = 'msrp_item';

    /**
     * Crosssell item collection
     *
     * @var Mage_Catalog_Model_Resource_Eav_Mysql4_Post_Link_Post_Collection
     */
    protected $_itemCollection;

    /**
     * Prepare crosssell items data
     *
     * @return Mage_Catalog_Block_Post_List_Crosssell
     */
    protected function _prepareData()
    {
        $post = Mage::registry('post');
        /* @var $post Mage_Catalog_Model_Post */

        $this->_itemCollection = $post->getCrossSellPostCollection()
            ->addFieldToSelect(Mage::getSingleton('catalog/config')->getPostAttributes());

//        Mage::getSingleton('catalog/post_status')->addSaleableFilterToCollection($this->_itemCollection);
        Mage::getSingleton('catalog/post_visibility')->addVisibleInCatalogFilterToCollection($this->_itemCollection);

        $this->_itemCollection->load();

        foreach ($this->_itemCollection as $post) {
            $post->setDoNotUseCategoryId(true);
        }

        return $this;
    }

    /**
     * Before rendering html process
     * Prepare items collection
     *
     * @return Mage_Catalog_Block_Post_List_Crosssell
     */
    protected function _beforeToHtml()
    {
        $this->_prepareData();
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve crosssell items collection
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Post_Link_Post_Collection
     */
    public function getItems()
    {
        return $this->_itemCollection;
    }

}

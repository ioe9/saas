<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog post random items block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Mio Core Team <developer@ioe9.com>
 */

class Mage_Catalog_Block_Post_List_Random extends Mage_Catalog_Block_Post_List
{
    protected function _getPostCollection()
    {
        if (is_null($this->_postCollection)) {
            $collection = Mage::getResourceModel('catalog/post_collection');
            Mage::getModel('catalog/layer')->preparePostCollection($collection);
            $collection->getSelect()->order('rand()');
            $collection->addStoreFilter();
            $numPosts = $this->getNumPosts() ? $this->getNumPosts() : 0;
            $collection->setPage(1, $numPosts);

            $this->_postCollection = $collection;
        }
        return $this->_postCollection;
    }
}

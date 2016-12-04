<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Mage_Catalog_Block_Post_List_Promotion extends Mage_Catalog_Block_Post_List
{
    protected function _getPostCollection()
    {
        if (is_null($this->_postCollection)) {
            $collection = Mage::getResourceModel('catalog/post_collection');
            Mage::getModel('catalog/layer')->preparePostCollection($collection);
// your custom filter
            $collection->addFieldToFilter('promotion', 1)
                ->addStoreFilter();

            $this->_postCollection = $collection;
        }
        return $this->_postCollection;
    }
}

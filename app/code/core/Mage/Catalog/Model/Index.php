<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Catalog Category/Post Index
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Model_Index
{
    /**
     * Rebuild indexes
     *
     * @return Mage_Catalog_Model_Index
     */
    public function rebuild()
    {
        Mage::getResourceSingleton('catalog/category')
            ->refreshPostIndex();
        foreach (Mage::app()->getStores() as $store) {
            Mage::getResourceSingleton('catalog/post')
                ->refreshEnabledIndex($store);
        }
        return $this;
    }
}

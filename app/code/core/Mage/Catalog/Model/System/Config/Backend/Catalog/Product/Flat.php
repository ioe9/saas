<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Flat post on/off backend
 */
class Mage_Catalog_Model_System_Config_Backend_Catalog_Post_Flat extends Mage_Core_Model_Config_Data
{
    /**
     * After enable flat posts required reindex
     *
     * @return Mage_Catalog_Model_System_Config_Backend_Catalog_Post_Flat
     */
    protected function _afterSave()
    {
        if ($this->isValueChanged() && $this->getValue()) {
            Mage::getSingleton('index/indexer')->getProcessByCode('catalog_post_flat')
                ->changeStatus(Mage_Index_Model_Process::STATUS_REQUIRE_REINDEX);
        }

        return $this;
    }
}

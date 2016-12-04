<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Url rewrite suffix backend
 */
class Mage_Catalog_Model_System_Config_Backend_Catalog_Url_Rewrite_Suffix extends Mage_Core_Model_Config_Data
{
    /**
     * Check url rewrite suffix - whether we can support it
     *
     * @return Mage_Catalog_Model_System_Config_Backend_Catalog_Url_Rewrite_Suffix
     */
    protected function _beforeSave()
    {
        Mage::helper('core/url_rewrite')->validateSuffix($this->getValue());
        return $this;
    }
}

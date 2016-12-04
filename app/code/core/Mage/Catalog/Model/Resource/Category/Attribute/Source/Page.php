<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Catalog category landing page attribute source
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Model_Resource_Category_Attribute_Source_Page extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * Return all block options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = Mage::getResourceModel('cms/block_collection')
                ->load()
                ->toOptionArray();
            array_unshift($this->_options, array('value' => '', 'label' => Mage::helper('catalog')->__('Please select a static block ...')));
        }
        return $this->_options;
    }
}

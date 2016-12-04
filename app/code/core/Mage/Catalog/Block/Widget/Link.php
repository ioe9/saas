<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Widget to display catalog link
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Mio Core Team <developer@ioe9.com>
 */

class Mage_Catalog_Block_Widget_Link
    extends Mage_Core_Block_Html_Link
    implements Mage_Widget_Block_Interface
{
    /**
     * Entity model name which must be used to retrieve entity specific data.
     * @var null|Mage_Catalog_Model_Resource_Eav_Mysql4_Abstract
     */
    protected $_entityResource = null;

    /**
     * Prepared href attribute
     *
     * @var string
     */
    protected $_href;

    /**
     * Prepared anchor text
     *
     * @var string
     */
    protected $_anchorText;

    /**
     * Prepare url using passed id and return it
     * or return false if path was not found.
     *
     * @return string|false
     */
    public function getHref()
    {
        if (!$this->_href) {

            if($this->hasStoreId()) {
                $store = Mage::app()->getStore($this->getStoreId());
            } else {
                $store = Mage::app()->getStore();
            }

            $idPath = explode('/', $this->_getData('id_path'));

            if (isset($idPath[0]) && isset($idPath[1]) && $idPath[0] == 'post') {

                /** @var $helper Mage_Catalog_Helper_Post */
                $helper = $this->_getFactory()->getHelper('catalog/post');
                $postId = $idPath[1];
                $categoryId = isset($idPath[2]) ? $idPath[2] : null;

                $this->_href = $helper->getFullPostUrl($postId, $categoryId);

            } elseif (isset($idPath[0]) && isset($idPath[1]) && $idPath[0] == 'category') {
                $categoryId = $idPath[1];
                if ($categoryId) {
                    /** @var $helper Mage_Catalog_Helper_Category */
                    $helper = $this->_getFactory()->getHelper('catalog/category');
                    $category = Mage::getModel('catalog/category')->load($categoryId);
                    $this->_href = $helper->getCategoryUrl($category);
                }
            }
        }

        if ($this->_href) {
            if (strpos($this->_href, "___store") === false) {
                $symbol = (strpos($this->_href, "?") === false) ? "?" : "&";
                $this->_href = $this->_href . $symbol . "___store=" . $store->getCode();
            }
        } else {
            return false;
        }

        return $this->_href;
    }

    /**
     * Prepare anchor text using passed text as parameter.
     * If anchor text was not specified get entity name from DB.
     *
     * @return string
     */
    public function getAnchorText()
    {
        if ($this->hasStoreId()) {
            $store = Mage::app()->getStore($this->getStoreId());
        } else {
            $store = Mage::app()->getStore();
        }

        if (!$this->_anchorText && $this->_entityResource) {
            if (!$this->_getData('anchor_text')) {
                $idPath = explode('/', $this->_getData('id_path'));
                if (isset($idPath[1])) {
                    $id = $idPath[1];
                    if ($id) {
                        $this->_anchorText = $this->_entityResource
                            ->getAttributeRawValue($id, 'name', $store);
                    }
                }
            } else {
                $this->_anchorText = $this->_getData('anchor_text');
            }
        }

        return $this->_anchorText;
    }

    /**
     * Render block HTML
     * or return empty string if url can't be prepared
     *
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->getHref()) {
            return parent::_toHtml();
        }
        return '';
    }
}

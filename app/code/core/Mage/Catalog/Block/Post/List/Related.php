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
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Block_Post_List_Related extends Mage_Catalog_Block_Post_Abstract
{
    /**
     * Default MAP renderer type
     *
     * @var string
     */
    protected $_mapRenderer = 'msrp_noform';

    protected $_itemCollection;

    protected function _prepareData()
    {
        $post = Mage::registry('post');
        /* @var $post Mage_Catalog_Model_Post */

        $this->_itemCollection = $post->getRelatedPostCollection()
            ->addFieldToSelect('required_options');

        $this->_itemCollection->load();

        foreach ($this->_itemCollection as $post) {
            $post->setDoNotUseCategoryId(true);
        }

        return $this;
    }

    protected function _beforeToHtml()
    {
        $this->_prepareData();
        return parent::_beforeToHtml();
    }

    public function getItems()
    {
        return $this->_itemCollection;
    }

    /**
     * Get tags array for saving cache
     *
     * @return array
     */
    public function getCacheTags()
    {
        return array_merge(parent::getCacheTags(), $this->getItemsTags($this->getItems()));
    }
}

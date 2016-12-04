<?php
/**
 *
 * @category    Mage
 * @package     Mage_Cms
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Cms Static Block Widget
 *
 * @category   Mage
 * @package    Mage_Cms
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Cms_Block_Widget_Block extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
    /**
     * Initialize cache
     *
     * @return null
     */
    protected function _construct()
    {
        parent::_construct();
        /*
        * setting cache to save the cms block
        */
        $this->setCacheTags(array(Mage_Cms_Model_Block::CACHE_TAG));
        $this->setCacheLifetime(false);
    }

    /**
     * Storage for used widgets
     *
     * @var array
     */
    static protected $_widgetUsageMap = array();

    /**
     * Prepare block text and determine whether block output enabled or not
     * Prevent blocks recursion if needed
     *
     * @return Mage_Cms_Block_Widget_Block
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $blockId = $this->getData('block_id');
        $blockHash = get_class($this) . $blockId;

        if (isset(self::$_widgetUsageMap[$blockHash])) {
            return $this;
        }
        self::$_widgetUsageMap[$blockHash] = true;

        if ($blockId) {
            $block = Mage::getModel('cms/block')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($blockId);
            if ($block->getIsActive()) {
                /* @var $helper Mage_Cms_Helper_Data */
                $helper = Mage::helper('cms');
                $processor = $helper->getBlockTemplateProcessor();
                $this->setText($processor->filter($block->getContent()));
                $this->addModelTags($block);
            }
        }

        unset(self::$_widgetUsageMap[$blockHash]);
        return $this;
    }

    /**
     * Retrieve values of properties that unambiguously identify unique content
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        $result = parent::getCacheKeyInfo();
        $blockId = $this->getBlockId();
        if ($blockId) {
            $result[] = $blockId;
        }
        return $result;
    }
}

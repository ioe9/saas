<?php
/**
 * Html notices block
 *
 * @category    Mage
 * @package     Mage_Page
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Page_Block_Html_CookieNotice extends Mage_Core_Block_Template
{
    /**
     * Get content for cookie restriction block
     *
     * @return string
     */
    public function getCookieRestrictionBlockContent()
    {
        $blockIdentifier = Mage::helper('core/cookie')->getCookieRestrictionNoticeCmsBlockIdentifier();
        $block = Mage::getModel('cms/block')->load($blockIdentifier, 'identifier');

        $html = '';
        if ($block->getIsActive()) {
            /* @var $helper Mage_Cms_Helper_Data */
            $helper = Mage::helper('cms');
            $processor = $helper->getBlockTemplateProcessor();
            $html = $processor->filter($block->getContent());
        }

        return $html;
    }
}

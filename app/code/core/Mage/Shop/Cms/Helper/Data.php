<?php
class Mage_Cms_Helper_Data extends Mage_Core_Helper_Abstract
{
    const PAGE_TEMPLATE_FILTER     = 'cms/template_filter';
    const BLOCK_TEMPLATE_FILTER    = 'cms/template_filter';

    /**
     * Retrieve Template processor for Page Content
     *
     * @return Varien_Filter_Template
     */
    public function getPageTemplateProcessor()
    {
        return Mage::getModel(self::PAGE_TEMPLATE_FILTER);
    }

    /**
     * Retrieve Template processor for Block Content
     *
     * @return Varien_Filter_Template
     */
    public function getBlockTemplateProcessor()
    {
        return Mage::getModel(self::BLOCK_TEMPLATE_FILTER);
    }
}

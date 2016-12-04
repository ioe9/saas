<?php


class Mage_Adminhtml_Block_Cache_Additional extends Mage_Adminhtml_Block_Template
{
    public function getCleanImagesUrl()
    {
        return $this->getUrl('*/*/cleanImages');
    }

    public function getCleanSwatchesUrl()
    {
        return $this->getUrl('*/*/cleanSwatches');
    }

    public function getCleanMediaUrl()
    {
        return $this->getUrl('*/*/cleanMedia');
    }
}

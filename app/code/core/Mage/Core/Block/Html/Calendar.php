<?php
class Mage_Core_Block_Html_Calendar extends Mage_Core_Block_Template
{
    protected function _toHtml()
    {
        return parent::_toHtml();
    }

    /**
     * Return offset of current timezone with GMT in seconds
     *
     * @return integer
     */
    public function getTimezoneOffsetSeconds()
    {
        return Mage::getSingleton('core/date')->getGmtOffset();
    }

    /**
     * Getter for store timestamp based on store timezone settings
     *
     * @param mixed $store
     * @return int
     */
    public function getStoreTimestamp($store = null)
    {
        return strtotime(date('Y-m-d H:i:s'));
    }
}

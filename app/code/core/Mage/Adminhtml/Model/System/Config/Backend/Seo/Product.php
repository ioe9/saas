<?php



class Mage_Adminhtml_Model_System_Config_Backend_Seo_Product extends Mage_Core_Model_Config_Data
{
    /**
     * Refresh category url rewrites if configuration was changed
     *
     * @return Mage_Adminhtml_Model_System_Config_Backend_Seo_Product
     */
    protected function _afterSave()
    {
        /**
         * Index model responsible for rewrites index
         */
//        if ($this->isValueChanged()) {
//            Mage::getSingleton('catalog/url')->refreshRewrites();
//        }
        return $this;
    }
}

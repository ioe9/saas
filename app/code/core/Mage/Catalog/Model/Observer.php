<?php
class Mage_Catalog_Model_Observer
{
    /**
     * Process catalog data after posts import
     *
     * @param   Varien_Event_Observer $observer
     * @return  Mage_Catalog_Model_Observer
     */
    public function catalogPostImportAfter(Varien_Event_Observer $observer)
    {
        Mage::getModel('catalog/url')->refreshRewrites();
        return $this;
    }
}

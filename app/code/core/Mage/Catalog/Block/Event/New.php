<?php

class Mage_Catalog_Block_Event_New extends Mage_Core_Block_Template
{
    public function getEvents()
    {
        $collection = Mage::getResourceModel('catalog/event_collection')
        	->addFieldToFilter('status',Mage_Catalog_Model_Event::STATUS_ENABLED)
        	->addFieldToFilter('date_to',array('gt'=>Mage::getSingleton('core/date')->date('Y-m-d')));
        return $collection;
    }

}

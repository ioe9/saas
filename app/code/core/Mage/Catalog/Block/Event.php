<?php
class Mage_Catalog_Block_Event extends Mage_Core_Block_Template
{
    public function getEvent()
    {
        if (!$this->getData('event') instanceof Mage_Catalog_Model_event) {
            if ($this->getData('event')->geteventId()) {
                $eventId = $this->getData('event')->geteventId();
            }
            if ($eventId) {
                $event = Mage::getModel('catalog/event')->load($eventId);
                if ($event) {
                    $this->setevent($event);
                }
            }
        }
        return $this->getData('event');
    }
}

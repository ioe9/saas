<?php
class Mage_Bill_Model_Resource_Reimburse extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init("bill/reimburse","reimburse_id");
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getDateCreate()) {
            $object->setDateCreate(Mage::getSingleton("core/date")->gmtDate());
        }
        if (!$object->getReiCode()) {
        	$nextIncrement = Mage::getSingleton("bill/reimburse")->getNextCodeIncrement();
        	$object->setReiCode('BX'.(date('Ymd')*10000+$nextIncrement));
        	$object->setReiCodeIncrement($nextIncrement);
        }
        return parent::_beforeSave($object);
    }

}


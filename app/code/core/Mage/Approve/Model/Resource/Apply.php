<?php
class Mage_Approve_Model_Resource_Apply extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init("approve/apply","apply_id");
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getDateCreate()) {
            $object->setDateCreate(Mage::getSingleton("core/date")->gmtDate());
        }
        if (!$object->getApplyCode()) {
        	$nextIncrement = Mage::getSingleton("approve/apply")->getNextCodeIncrement();
        	$object->setApplyCode('SP'.(date('Ymd')*10000+$nextIncrement));
        	$object->setApplyCodeIncrement($nextIncrement);
        }
        return parent::_beforeSave($object);
    }

}


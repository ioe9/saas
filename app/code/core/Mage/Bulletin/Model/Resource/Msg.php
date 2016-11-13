<?php
class Mage_Bulletin_Model_Resource_Msg extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init("bulletin/msg","msg_id");
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getDateCreate()) {
            $object->setDateCreate(Mage::getSingleton("core/date")->gmtDate());
        }
        return parent::_beforeSave($object);
    }

}


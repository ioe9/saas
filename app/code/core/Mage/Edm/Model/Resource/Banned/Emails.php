<?php
class Mage_Edm_Model_Resource_Banned_Emails extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/banned_emails', 'banid');
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getCreatedate()) {
            $object->setCreatedate(Mage::getSingleton('core/date')->gmtDate());
        }
        return parent::_beforeSave($object);
    }

}

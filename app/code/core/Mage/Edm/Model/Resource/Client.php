<?php
class Mage_Edm_Model_Resource_Client extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/client', 'client_id');
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getDateCreate()) {
            $object->setDateCreate(Mage::getSingleton('core/date')->gmtDate());
        }
        return parent::_beforeSave($object);
    }

}

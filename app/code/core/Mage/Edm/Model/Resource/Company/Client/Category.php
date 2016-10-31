<?php
class Mage_Edm_Model_Resource_Company_Client_Category extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/company_client_category', 'category_id');
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getDateCreate()) {
            $object->setDateCreate(Mage::getSingleton('core/date')->gmtDate());
        }
        return parent::_beforeSave($object);
    }

}

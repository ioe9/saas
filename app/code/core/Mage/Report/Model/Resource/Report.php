<?php
class Mage_Report_Model_Resource_Report extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('report/report', 'report_id');
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getDateCreate()) {
            $object->setDateCreate(Mage::getSingleton('core/date')->gmtDate());  
        }
        if (!$object->getId() && Mage::registry('current_user')) {
        	$object->setReportCreate(Mage::registry('current_user')->getId());
        }
        return parent::_beforeSave($object);
    }

}

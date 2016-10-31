<?php
class Mage_Edm_Model_Resource_Urlprocess extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/urlprocess', 'url_id');
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getDateCreate()) {
            $object->setDateCreate(Mage::getSingleton('core/date')->gmtDate());
        }
        if (!$object->getData('client_id')) {
        	//更新client_id
        	$clientHelper = Mage::helper('edm/front_client');
        	$url = $object->getData('url');
			$url = $clientHelper->cleanUrl($url);
			$client = $clientHelper->getClientByUrl($url);
			if ($client && $client->getId()) {
				$object->setClientId($client->getId());
			} else {
				$client = Mage::getModel('edm/client')
					->setData('website',$url)
					->save();
				$object->setClientId($client->getId());
			}
        }

        return parent::_beforeSave($object);
    }

}

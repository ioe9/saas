<?php
class Mage_Edm_Model_Resource_Client_Rule_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/client_rule');
    }
    public function getAsOptionArray()
    {
        $arr = array();
        foreach ($this as $item) {
            $id = $item->getData('rule_id');
			$data = array();
            $data['value'] = $id;
            $data['label'] = $item->getData('name');
            $res[$id] = $data;
        }

        return $res;
    }
}

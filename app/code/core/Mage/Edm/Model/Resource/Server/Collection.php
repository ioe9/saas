<?php
class Mage_Edm_Model_Resource_Server_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/server');
    }
    public function getAsOptionArray()
    {
        $arr = array();
        foreach ($this as $item) {
            $id = $item->getData('server_id');
			$data = array();
            $data['value'] = $id;
            $data['label'] = $item->getData('server_name');
            $res[$id] = $data;
        }

        return $res;
    }
}

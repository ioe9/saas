<?php
class Mage_Edm_Model_Resource_Users_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/users');
    }
    public function getAsOptionArray()
    {
        $arr = array();
        foreach ($this as $item) {
            $id = $item->getData('userid');
			$data = array();
            $data['value'] = $id;
            $data['label'] = $item->getData('username');
            $res[$id] = $data;
        }

        return $res;
    }
}

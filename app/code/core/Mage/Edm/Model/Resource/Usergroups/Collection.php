<?php
class Mage_Edm_Model_Resource_Usergroups_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/usergroups');
    }
    public function getAsOptionArray()
    {
        $arr = array();
        foreach ($this as $item) {
            $id = $item->getData('groupid');
			$data = array();
            $data['value'] = $id;
            $data['label'] = $item->getData('groupname');
            $res[$id] = $data;
        }

        return $res;
    }
}

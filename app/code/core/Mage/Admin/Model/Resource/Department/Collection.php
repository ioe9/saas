<?php
class Mage_Admin_Model_Resource_Department_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('admin/department');
    }
    public function getAsOptionArray()
    {
        $arr = array();
        foreach ($this as $item) {
            $id = $item->getData('department_id');
			$data = array();
            $data['value'] = $id;
            $data['label'] = $item->getData('dep_name');
            $res[$id] = $data;
        }
        return $res;
    }
}

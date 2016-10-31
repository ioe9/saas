<?php
class Mage_Admin_Model_Resource_Company_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('admin/company');
    }
    public function getAsOptionArray()
    {
        $arr = array();
        foreach ($this as $item) {
            $id = $item->getData('company_id');
			$data = array();
            $data['value'] = $id;
            $data['label'] = $item->getData('name');
            $res[$id] = $data;
        }
        return $res;
    }
}

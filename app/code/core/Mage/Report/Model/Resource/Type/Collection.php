<?php
class Mage_Report_Model_Resource_Type_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('report/type');
    }
    public function getAsOptionArray()
    {
        $arr = array();
        foreach ($this as $item) {
            $id = $item->getData('type_id');
			$data = array();
            $data['value'] = $id;
            $data['label'] = $item->getData('type_name');
            $res[$id] = $data;
        }

        return $res;
    }
}

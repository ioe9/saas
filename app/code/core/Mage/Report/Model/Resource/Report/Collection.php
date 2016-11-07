<?php
class Mage_Report_Model_Resource_Report_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('report/report');
    }
    public function getAsOptionArray()
    {
        $arr = array();
        foreach ($this as $item) {
            $id = $item->getData('report_id');
			$data = array();
            $data['value'] = $id;
            $data['label'] = $item->getData('report_name');
            $res[$id] = $data;
        }

        return $res;
    }
}

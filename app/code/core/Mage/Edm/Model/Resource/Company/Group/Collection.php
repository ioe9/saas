<?php
class Mage_Edm_Model_Resource_Company_Group_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/company_group');
    }
    public function getAsOptionArray()
    {
        $arr = array();
        foreach ($this as $item) {
            $id = $item->getData('group_id');
			$data = array();
            $data['value'] = $id;
            $data['label'] = $item->getData('name');
            $res[$id] = $data;
        }

        return $res;
    }
}

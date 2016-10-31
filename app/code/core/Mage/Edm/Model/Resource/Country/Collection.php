<?php
class Mage_Edm_Model_Resource_Country_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/country');
    }
    public function getAsOptionArray($withEmpty=false)
    {
        $res = array();
        if ($withEmpty) {
        	$res[''] = '--请选择--';
        }
        foreach ($this as $item) {
            $id = $item->getData('country_id');
			$data = array();
            $data['value'] = $id;
            $data['label'] = $item->getData('name') ? $item->getData('name') : $id;
            $res[$id] = $item->getData('name') ? $item->getData('name') : $id;
        }

        return $res;
    }
}

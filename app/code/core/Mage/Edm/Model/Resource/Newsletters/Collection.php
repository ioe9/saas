<?php
class Mage_Edm_Model_Resource_Newsletters_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/newsletters');
    }
    public function getAsOptionArray()
    {
        $arr = array();
        foreach ($this as $item) {
            $id = $item->getData('newsletterid');
			$data = array();
            $data['value'] = $id;
            $data['label'] = $item->getData('name');
            $res[] = $data;
        }

        return $res;
    }
}

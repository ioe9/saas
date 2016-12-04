<?php
class Mage_Edm_Model_Resource_Template_Module_Item_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/template_module_item');
    }
    public function getAsOptionArray()
    {
        $arr = array();
        foreach ($this as $item) {
            $id = $item->getData('item_id');
			$data = array();
            $data['value'] = $id;
            $data['label'] = $item->getData('content');
            $res[$id] = $data;
        }

        return $res;
    }
}

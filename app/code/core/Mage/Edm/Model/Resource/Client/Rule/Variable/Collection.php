<?php
class Mage_Edm_Model_Resource_Client_Rule_Variable_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('edm/client_rule_variable');
    }
    public function getAsOptionArray($withEmpty)
    {
    	$res = array();
    	if ($withEmpty) {
    		$res[] = array('value'=>'','label'=>'全部');
    	}
        foreach ($this as $item) {
            $id = $item->getData('name');
			$data = array();
            $data['value'] = $id;
            $data['label'] = $item->getData('name');
            $res[$id] = $data;
        }

        return $res;
    }
}

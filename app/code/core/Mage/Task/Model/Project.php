<?php
class Mage_Task_Model_Project extends Mage_Core_Model_Abstract
{
	const PRIVATE_NO = 0;
	const PRIVATE_YES = 1;
    protected function _construct()
    {
        $this->_init('task/project');
    }
    

    
    public function getAsOptions() {
    	$collection = $this->getCollection();
    	$res = array();
    	foreach ($collection as $_item) {
    		$res[$_item->getId()] = $_item->getData('project_name');
    	}
    	return $res;
    }
    
    public function getPrivateOptions() {
    	return array(
    		self::PRIVATE_NO => '公开', 
    		self::PRIVATE_YES => '私密', 
    	);
    }
    public function getPrivateOptionsArray() {
    	return array(
    		array('label'=>'公开','value'=>self::PRIVATE_NO),
    		array('label'=>'私密','value'=>self::PRIVATE_YES),

    	);
    }
}

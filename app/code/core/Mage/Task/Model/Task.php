<?php
class Mage_Task_Model_Task extends Mage_Core_Model_Abstract
{
	const MEDIA_IMAGE_PREFIX = 'task';
    
    const LEVEL_LOW = 0;
    const LEVEL_MID = 1;
    const LEVEL_HIG = 2;
    const LEVEL_EME = 3;
    
    const STATUS_PENDING = 0;
    const STATUS_PROCESS = 1;
    const STATUS_PAUSED = 2;
    const STATUS_AUDIT = 3;
    const STATUS_FINISH = 4;
    
    
    protected function _construct()
    {
        $this->_init('task/task');
    }
    
    public function getLevelOptions() {
    	return array(
    		self::LEVEL_LOW => '低',
    		self::LEVEL_MID => '中',
    		self::LEVEL_HIG => '高',
    		self::LEVEL_EME => '紧急',
    	);
    }
    
    public function getStatusOptions() {
    	return array(
    		self::STATUS_PENDING => '待认领',
    		self::STATUS_PROCESS => '处理中',
    		self::STATUS_PAUSED => '挂起中',
    		self::STATUS_AUDIT => '待验收',
    		self::STATUS_FINISH => '已完成',
    	);
    }
    

}

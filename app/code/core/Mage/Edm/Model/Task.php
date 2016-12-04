<?php
class Mage_Edm_Model_Task extends Mage_Core_Model_Abstract
{

	const TYPE_EMAIL_COLLECT = 0;
	const TYPE_LINKEDIN = 1;
	const TYPE_FACEBOOK = 2;
	const TYPE_EMAIL_CHECK = 3;
	const TYPE_OTHER = 99;
	
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/task');
    }

	public function getTypeOptions() {
		return array(
			self::TYPE_EMAIL_COLLECT => '邮箱采集',
			self::TYPE_LINKEDIN => 'LinkedIn采集',
			self::TYPE_FACEBOOK => 'Facebook采集',
			self::TYPE_EMAIL_CHECK => '邮箱验证',
			self::TYPE_OTHER => '其他任务',
		);
	}
    public function getChildren() {
    	if ($this->getId()) {
    		$children = $this->getCollection()
	    		->addFieldToFilter('task_parent',$this->getId());
			return $children;
    	} else {
    		return false;
    	}
	    	
    }
}

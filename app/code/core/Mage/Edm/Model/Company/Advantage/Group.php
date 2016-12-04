<?php
class Mage_Edm_Model_Company_Advantage_Group extends Mage_Core_Model_Abstract
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 0;
	
	const TYPE_CUSTOM = 1;
	const TYPE_CONFIG = 0;
    protected function _construct()
    {
        $this->_init("edm/company_advantage_group");
    }
	public function getStatusOptions() {
		$arr = array(
			self::STATUS_ENABLE => '启用',
			self::STATUS_DISABLE => '禁用',
			
		);		
		return $arr;
	}
	public function getTypeOptions() {
		$arr = array(
			self::TYPE_CONFIG => '使用配置',
			self::TYPE_CUSTOM => '自定义',
			
		);		
		return $arr;
	}
}

<?php
class Mage_Edm_Model_Company_Template extends Mage_Core_Model_Abstract
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 0;
    protected function _construct()
    {
        $this->_init("edm/company_template");
    }
    
    public function getLinks() {
    	$linkCollection = Mage::getResourceModel('edm/company_template_module_link_collection')
    		->addFieldToFilter('link_template',$this->getId())
    		->setOrder('link_order','asc');
		$linkCollection->getSelect()
			->join(array('m'=>'edm_templates_module'),'main_table.link_module=m.module_id',array('module_name','module_id'));
		return $linkCollection;
    }
	
	/***
	 * 获取上一个最大排序值
	 */
	public function getNextLinkSort() {
		$lastItem = Mage::getResourceModel('edm/company_template_module_link_collection')
			->addFieldToFilter('link_template',$this->getId())
			->setOrder('link_order','desc')
			->setPageSize(1)
			->getLastItem();
		return ($lastItem->getData('link_order')+1);
	}
	
	public function getStatusOptions() {
		$arr = array(
			self::STATUS_ENABLE => '启用',
			self::STATUS_DISABLE => '禁用',
		);		
		return $arr;
	}
}

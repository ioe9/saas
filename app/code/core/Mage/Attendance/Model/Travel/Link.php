<?php
class Mage_Attendance_Model_Travel_Link extends Mage_Core_Model_Abstract
{
	const LINK_TYPE_TO = 0;
	const LINK_TYPE_CC = 1;	
    protected function _construct()
    {
        $this->_init("attendance/travel_link");
    }
	/***
	 * 获取报告关联人
	 */
	public function getReportLink($objectId,$type = self::LINK_TYPE_TO) {
		$collection = $this->getCollection()
			->addFieldToFilter('link_type',$type)
			->addFieldToFilter('link_object',$objectId);
		$collection->getSelect()
	    		->joinLeft(
	    			array('u'=>'saas_admin_user'),
					'main_table.link_object=u.user_id',
					array('name')
				);
	}
	
	public function getLinkedChooserSelected($objectId,$linkType=self::LINK_TYPE_TO) {
		$collection = Mage::getModel('admin/user')->getUserByCompany();
		$collection->getSelect()
				->join(
	    			array('link'=>'attendance_travel_link'),
					'link.link_user=main_table.user_id',
					array('link_type','link_object')
				);
		$collection->addFieldToFilter('link_object',$objectId);
		$collection->addFieldToFilter('link_type',$linkType);
		
		$data = array();
		foreach ($collection as $item) {
			$tmp = array(
	    		'id' => $item['user_id'],
	    		'name' => $item['name'],
	    		'icon' => $item['user_avatar'] ? $item['user_avatar'] : Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'adminhtml/default/default/images/avatar/avatar_l.png',
	    		'type' => '3',
	    	);
			array_push($data,$tmp);
		}
		return $data;
	    		
	}
}

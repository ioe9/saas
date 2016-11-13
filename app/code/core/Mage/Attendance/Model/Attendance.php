<?php
class Mage_Attendance_Model_Attendance extends Mage_Core_Model_Abstract
{
	
    protected function _construct()
    {
        $this->_init("attendance/attendance");
    }
    
    public function getSign($userId=null, $date=null) {
    	if (!$userId) {
    		$userId = Mage::registry('current_user')->getId();
    	}
    	if (!$date) {
    		$date = Mage::getSingleton('core/date')->gmtDate('Y-m-d');
    	}
    	$att = $this->getCollection()
    		->addFieldToFilter('att_create',$userId)
    		->addFieldToFilter('att_date',$date)
    		->getFirstItem()
    		->setPageSize(1);
		return $att;
    }
    /**
     * 获取一个用户指定月份的签到数据
     */
	public function getSignDaysByMonth($userId=null, $month=null,$isJson = false) {
    	if (!$userId) {
    		$userId = Mage::registry('current_user')->getId();
    	}
    	if (!$month) {
    		$month = Mage::getSingleton('core/date')->gmtDate('Y-m');
    	}
    	$atts = $this->getCollection()
    		->addFieldToFilter('att_create',$userId)
    		->addFieldToFilter('att_month',$month);
		//echo $atts->getSelect();
		if ($isJson) {
			$arr = array();
			foreach ($atts as $item) {
				array_push($arr, array(
					'day' => date('d',strtotime($item->getData('att_date'))),
					'sign' => true,
					'leave' => true,
					'travel' => true,
					'fieldwork' => true,
					'overtime' => true,
				));
			}
			return $arr;
		} else {
			return $atts;
		}
		
    }
    
    
}

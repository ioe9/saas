<?php
/***
 * 考勤
 */
class Mage_Adminhtml_AttendanceController extends Mage_Adminhtml_Controller_Attendance
{
    public function indexAction()
    {
       $this->_forward('attendance');
    }
    
    public function attendanceAction()
    {
        $this->_title($this->__('出勤管理'));
        $this->loadLayout();
        $this->_setActiveMenu('attendance/attendance');
        $this->_addContent($this->getLayout()->createBlock('attendance/adminhtml_attendance', 'attendance'));
        $this->renderLayout();
    }
    
    /**
     * 获取指定月份的签到信息
     */
    public function getSignedDataAction() {
    	echo json_encode(array('data'=>array()));
    }
	/***
	 * 签到
	 */
	public function doSignInAction() {
		$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
		$now = Mage::getSingleton('core/date')->gmtDate('Y-m-d H:i:s');
		$date = Mage::getSingleton('core/date')->gmtDate('Y-m-d');
		$att = Mage::getModel('attendance/attendance');
		$user = Mage::registry('current_user');
		$oldAtt = $att->getSign($user->getId(), $date);
		if (!$oldAtt->getId()) {
			$data = array(
				'att_company' => Mage::registry('current_company')->getId(),
				'att_date' => $date,
				'att_create' => $user->getId(),
				'att_in' => $now,
				'att_in_ip' => Mage::helper('core/http')->getRemoteAddr(),
			);
			$att->addData($data);
			try {
				$att->save();
				$res['data'] = 1;
			} catch (Exception $e) {
				$res['succeed'] = false;
				$res['msg'] = "系统异常，请稍后重试或联系管理员。";
			}
		} else {
			//已签到
			$res['data'] = 0;
		}
		echo json_encode($res);
	}
	
	/***
	 * 签出
	 */
	public function doSignOutAction() {
		$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
		$now = Mage::getSingleton('core/date')->gmtDate('Y-m-d H:i:s');
		$date = Mage::getSingleton('core/date')->gmtDate('Y-m-d');
		$att = Mage::getModel('attendance/attendance');
		$user = Mage::registry('current_user');
		$oldAtt = $att->getSign($user->getId(), $date);
		if (!$oldAtt->getId()) {
			$res['msg'] = "您尚未签到！";
			$res['data'] = 0;
		} else {
			
			if ($oldAtt->getData('att_out')) {
				//已签出
				$res['msg'] = "您已签出！";
				$res['data'] = 0;
			} else {
				$oldAtt->setData('att_out',$now);
				$oldAtt->setData('att_out_ip',Mage::helper('core/http')->getRemoteAddr());
				try {
					$oldAtt->save();
					$res['data'] = 1;
				} catch (Exception $e) {
					$res['succeed'] = false;
					$res['msg'] = "系统异常，请稍后重试或联系管理员。";
				}
				
			}
		}
		echo json_encode($res);
	}
}
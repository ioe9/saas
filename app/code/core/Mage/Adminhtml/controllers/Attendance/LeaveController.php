<?php
/***
 * 请假管理
 */
class Mage_Adminhtml_Attendance_LeaveController extends Mage_Adminhtml_Controller_Report
{
	/****
	 * 请假管理
	 */
    public function indexAction()
    {
        $this->_title($this->__('请假管理'));
        $this->loadLayout();
        $this->_setActiveMenu('attendance/leave');
        $this->_addContent($this->getLayout()->createBlock('attendance/adminhtml_leave', 'leave'));
        $this->renderLayout();
    }
	

    public function newAction()
    {
    	$this->_forward('edit');
    }
    
    public function editAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$leave = Mage::getModel('attendance/leave')->load($id);
    	
    	if ($leave->getId()) {
    		//判断归属
    		if ($leave->getData('leave_create')!=$this->_getUser()->getId()) {
    			$this->_getSession()->addError('非法操作！');
    			$this->_redirect('*/*');
    		}
    	}
    	Mage::register('current_leave',$leave);
        
        $this->loadLayout();
        if ($leave->getId()) {
        	$this->_title($this->__('编辑请假申请'));
        } else {
        	$this->_title($this->__('新建请假申请'));
        }
        $this->_setActiveMenu('attendance/leave');
        $this->_addContent($this->getLayout()->createBlock('attendance/adminhtml_leave_edit', 'leave.edit'));
        $this->renderLayout();
    }
    
    /*
     * 保存请假管理
     */
    public function saveAction() {
		$data = $this->getRequest()->getParams();
		$leave = Mage::getModel('attendance/leave');
		if (isset($data['id']) && $data['id']) {
			$leave->load($data['id']);
			if ($leave->getData('leave_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		} else {
			$data['leave_create'] = Mage::registry('current_user')->getId();
		}
		unset($data['id']);
        //echo "<xmp>";var_dump($data);die();     
		$data['leave_company'] = Mage::registry('current_company')->getId();
		$data['leave_cdepartment'] = Mage::registry('current_user')->getDepartment()->getId();
		$leave->addData($data);
		try {
			$leave->save();
			$auditOldArr = explode(',',$data['leave_audit_old']);
			$auditArr = explode(',',$data['leave_audit']);
			$ccOldArr = explode(',',$data['leave_cc_old']);
			$ccArr = explode(',',$data['leave_cc']);
			
			$delAuditArr = array_diff($auditOldArr,$auditArr);
			$addAuditArr = array_diff($auditArr,$auditOldArr);
			
			$delCcArr = array_diff($ccOldArr,$ccArr);
			$addCcArr = array_diff($ccArr,$ccOldArr);
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');    
			
			$leaveId = $leave->getId();
			$auditType = Mage_Attendance_Model_Fieldwork_Link::LINK_TYPE_TO;
			$auditCc = Mage_Attendance_Model_Fieldwork_Link::LINK_TYPE_CC;
			foreach ($delAuditArr as $v) {
				$v = (int)$v;
				$write->query("delete from attendance_leave_link where link_object='$leaveId' and link_type='$auditType' and link_user='$v'");  
			}
			foreach ($addAuditArr as $v) {
				$v = (int)$v;
				$write->query("insert into attendance_leave_link(link_object,link_type,link_user) values('$leaveId','$auditType','$v')");  
			}
			
			foreach ($delCcArr as $v) {
				$v = (int)$v;
				$write->query("delete from attendance_leave_link where link_object='$leaveId' and link_type='$auditCc' and link_user='$v'");  
			}
			foreach ($addCcArr as $v) {
				$v = (int)$v;
				$write->query("insert into attendance_leave_link(link_object,link_type,link_user) values('$leaveId','$auditCc','$v')");  
			}
			
			$this->_getSession()->addSuccess('请假申请保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("请假申请保存失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}
    
    public function viewAction() {
    	$id = (int)$this->getRequest()->getParam('id');
    	$leave = Mage::getModel('attendance/leave')->load($id);
    	Mage::register('current_leave',$leave);
    	if ($leave->getId()) {
    		 $this->_title($this->__('查看请假'));
	        $this->loadLayout();
	        $this->_setActiveMenu('attendance/leave');
	        $this->_addContent($this->getLayout()->createBlock('attendance/adminhtml_leave_view', 'leave.view'));
	        $this->renderLayout();
    	} else {
    		$this->_getSession()->addError('请假记录已不存在，请重试。');
			$this->_redirect('*/*');
    	}
    }
    
    /****************** audit *******************/
    /*
     * 保存审核信息
     */
    public function saveAuditAction() {
		$data = $this->getRequest()->getParams();
		$leave = Mage::getModel('attendance/leave');
		$audit = Mage::getModel('attendance/leave_audit');
		if (isset($data['audit_rei']) && $data['audit_rei']) {
			$leave->load($data['audit_rei']);
			if ($leave->getData('rei_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		}
		$data['audit_create'] = Mage::registry('current_user')->getId();
		$audit->addData($data);
		try {
			$audit->save();
			$this->_getSession()->addSuccess('审核提交成功');
		} catch (Exception $e) {
			echo $e->getMessage();die();
			$this->_getSession()->addError("审核保存失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}


}
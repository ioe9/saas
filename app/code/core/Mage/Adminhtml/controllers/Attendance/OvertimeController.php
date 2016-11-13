<?php
/***
 * 加班管理
 */
class Mage_Adminhtml_Attendance_OvertimeController extends Mage_Adminhtml_Controller_Report
{
	/****
	 * 加班管理
	 */
    public function indexAction()
    {
        $this->_title($this->__('加班管理'));
        $this->loadLayout();
        $this->_setActiveMenu('attendance/overtime');
        $this->_addContent($this->getLayout()->createBlock('attendance/adminhtml_overtime', 'overtime'));
        $this->renderLayout();
    }
	

    public function newAction()
    {
    	$this->_forward('edit');
    }
    
    public function editAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$overtime = Mage::getModel('attendance/overtime')->load($id);
    	
    	if ($overtime->getId()) {
    		//判断归属
    		if ($overtime->getData('overtime_create')!=$this->_getUser()->getId()) {
    			$this->_getSession()->addError('非法操作！');
    			$this->_redirect('*/*');
    		}
    	}
    	Mage::register('current_overtime',$overtime);
        
        $this->loadLayout();
        if ($overtime->getId()) {
        	$this->_title($this->__('编辑加班申请'));
        } else {
        	$this->_title($this->__('新建加班申请'));
        }
        $this->_setActiveMenu('attendance/overtime');
        $this->_addContent($this->getLayout()->createBlock('attendance/adminhtml_overtime_edit', 'overtime.edit'));
        $this->renderLayout();
    }
    
    /*
     * 保存加班管理
     */
    public function saveAction() {
		$data = $this->getRequest()->getParams();
		$overtime = Mage::getModel('attendance/overtime');
		if (isset($data['id']) && $data['id']) {
			$overtime->load($data['id']);
			if ($overtime->getData('overtime_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		} else {
			$data['overtime_create'] = Mage::registry('current_user')->getId();
		}
		unset($data['id']);
        //echo "<xmp>";var_dump($data);die();     
		$data['overtime_company'] = Mage::registry('current_company')->getId();
		$data['overtime_cdepartment'] = Mage::registry('current_user')->getDepartment()->getId();
		$overtime->addData($data);
		try {
			$overtime->save();
			$auditOldArr = explode(',',$data['overtime_audit_old']);
			$auditArr = explode(',',$data['overtime_audit']);
			$ccOldArr = explode(',',$data['overtime_cc_old']);
			$ccArr = explode(',',$data['overtime_cc']);
			
			$delAuditArr = array_diff($auditOldArr,$auditArr);
			$addAuditArr = array_diff($auditArr,$auditOldArr);
			
			$delCcArr = array_diff($ccOldArr,$ccArr);
			$addCcArr = array_diff($ccArr,$ccOldArr);
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');    
			
			$overtimeId = $overtime->getId();
			$auditType = Mage_Attendance_Model_Fieldwork_Link::LINK_TYPE_TO;
			$auditCc = Mage_Attendance_Model_Fieldwork_Link::LINK_TYPE_CC;
			foreach ($delAuditArr as $v) {
				$v = (int)$v;
				$write->query("delete from attendance_overtime_link where link_object='$overtimeId' and link_type='$auditType' and link_user='$v'");  
			}
			foreach ($addAuditArr as $v) {
				$v = (int)$v;
				$write->query("insert into attendance_overtime_link(link_object,link_type,link_user) values('$overtimeId','$auditType','$v')");  
			}
			
			foreach ($delCcArr as $v) {
				$v = (int)$v;
				$write->query("delete from attendance_overtime_link where link_object='$overtimeId' and link_type='$auditCc' and link_user='$v'");  
			}
			foreach ($addCcArr as $v) {
				$v = (int)$v;
				$write->query("insert into attendance_overtime_link(link_object,link_type,link_user) values('$overtimeId','$auditCc','$v')");  
			}
			
			$this->_getSession()->addSuccess('加班申请保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("加班申请保存失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}
    
    public function viewAction() {
    	$id = (int)$this->getRequest()->getParam('id');
    	$overtime = Mage::getModel('attendance/overtime')->load($id);
    	Mage::register('current_overtime',$overtime);
    	if ($overtime->getId()) {
    		 $this->_title($this->__('查看加班'));
	        $this->loadLayout();
	        $this->_setActiveMenu('attendance/overtime');
	        $this->_addContent($this->getLayout()->createBlock('attendance/adminhtml_overtime_view', 'overtime.view'));
	        $this->renderLayout();
    	} else {
    		$this->_getSession()->addError('加班记录已不存在，请重试。');
			$this->_redirect('*/*');
    	}
    }
    
    /****************** audit *******************/
    /*
     * 保存审核信息
     */
    public function saveAuditAction() {
		$data = $this->getRequest()->getParams();
		$overtime = Mage::getModel('attendance/overtime');
		$audit = Mage::getModel('attendance/overtime_audit');
		if (isset($data['audit_rei']) && $data['audit_rei']) {
			$overtime->load($data['audit_rei']);
			if ($overtime->getData('rei_company')!=$this->_getCompanyId()) {
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
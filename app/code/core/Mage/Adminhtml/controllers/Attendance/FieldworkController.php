<?php
/***
 * 外勤管理
 */
class Mage_Adminhtml_Attendance_FieldworkController extends Mage_Adminhtml_Controller_Report
{
	/****
	 * 外勤管理
	 */
    public function indexAction()
    {
        $this->_title($this->__('外勤管理'));
        $this->loadLayout();
        $this->_setActiveMenu('attendance/fieldwork');
        $this->_addContent($this->getLayout()->createBlock('attendance/adminhtml_fieldwork', 'fieldwork'));
        $this->renderLayout();
    }
	

    public function newAction()
    {
    	$this->_forward('edit');
    }
    
    public function editAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$fieldwork = Mage::getModel('attendance/fieldwork')->load($id);
    	
    	if ($fieldwork->getId()) {
    		//判断归属
    		if ($fieldwork->getData('fieldwork_create')!=$this->_getUser()->getId()) {
    			$this->_getSession()->addError('非法操作！');
    			$this->_redirect('*/*');
    		}
    	}
    	Mage::register('current_fieldwork',$fieldwork);
        
        $this->loadLayout();
        if ($fieldwork->getId()) {
        	$this->_title($this->__('编辑外勤申请'));
        } else {
        	$this->_title($this->__('新建外勤申请'));
        }
        $this->_setActiveMenu('attendance/fieldwork');
        $this->_addContent($this->getLayout()->createBlock('attendance/adminhtml_fieldwork_edit', 'fieldwork.edit'));
        $this->renderLayout();
    }
    
    /*
     * 保存外勤管理
     */
    public function saveAction() {
		$data = $this->getRequest()->getParams();
		$fieldwork = Mage::getModel('attendance/fieldwork');
		if (isset($data['id']) && $data['id']) {
			$fieldwork->load($data['id']);
			if ($fieldwork->getData('fieldwork_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		} else {
			$data['fieldwork_create'] = Mage::registry('current_user')->getId();
		}
		unset($data['id']);
        //echo "<xmp>";var_dump($data);die();     
		$data['fieldwork_company'] = Mage::registry('current_company')->getId();
		$data['fieldwork_cdepartment'] = Mage::registry('current_user')->getDepartment()->getId();
		$fieldwork->addData($data);
		try {
			$fieldwork->save();
			$auditOldArr = explode(',',$data['fieldwork_audit_old']);
			$auditArr = explode(',',$data['fieldwork_audit']);
			$ccOldArr = explode(',',$data['fieldwork_cc_old']);
			$ccArr = explode(',',$data['fieldwork_cc']);
			
			$delAuditArr = array_diff($auditOldArr,$auditArr);
			$addAuditArr = array_diff($auditArr,$auditOldArr);
			
			$delCcArr = array_diff($ccOldArr,$ccArr);
			$addCcArr = array_diff($ccArr,$ccOldArr);
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');    
			
			$fieldworkId = $fieldwork->getId();
			$auditType = Mage_Attendance_Model_Fieldwork_Link::LINK_TYPE_TO;
			$auditCc = Mage_Attendance_Model_Fieldwork_Link::LINK_TYPE_CC;
			foreach ($delAuditArr as $v) {
				$v = (int)$v;
				$write->query("delete from attendance_fieldwork_link where link_object='$fieldworkId' and link_type='$auditType' and link_user='$v'");  
			}
			foreach ($addAuditArr as $v) {
				$v = (int)$v;
				$write->query("insert into attendance_fieldwork_link(link_object,link_type,link_user) values('$fieldworkId','$auditType','$v')");  
			}
			
			foreach ($delCcArr as $v) {
				$v = (int)$v;
				$write->query("delete from attendance_fieldwork_link where link_object='$fieldworkId' and link_type='$auditCc' and link_user='$v'");  
			}
			foreach ($addCcArr as $v) {
				$v = (int)$v;
				$write->query("insert into attendance_fieldwork_link(link_object,link_type,link_user) values('$fieldworkId','$auditCc','$v')");  
			}
			
			$this->_getSession()->addSuccess('外勤申请保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("外勤申请保存失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}
    
    public function viewAction() {
    	$id = (int)$this->getRequest()->getParam('id');
    	$fieldwork = Mage::getModel('attendance/fieldwork')->load($id);
    	Mage::register('current_fieldwork',$fieldwork);
    	if ($fieldwork->getId()) {
    		 $this->_title($this->__('查看外勤'));
	        $this->loadLayout();
	        $this->_setActiveMenu('attendance/fieldwork');
	        $this->_addContent($this->getLayout()->createBlock('attendance/adminhtml_fieldwork_view', 'fieldwork.view'));
	        $this->renderLayout();
    	} else {
    		$this->_getSession()->addError('外勤记录已不存在，请重试。');
			$this->_redirect('*/*');
    	}
    }
    
    /****************** audit *******************/
    /*
     * 保存审核信息
     */
    public function saveAuditAction() {
		$data = $this->getRequest()->getParams();
		$fieldwork = Mage::getModel('attendance/fieldwork');
		$audit = Mage::getModel('attendance/fieldwork_audit');
		if (isset($data['audit_rei']) && $data['audit_rei']) {
			$fieldwork->load($data['audit_rei']);
			if ($fieldwork->getData('rei_company')!=$this->_getCompanyId()) {
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
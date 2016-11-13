<?php
/***
 * 出差管理
 */
class Mage_Adminhtml_Attendance_TravelController extends Mage_Adminhtml_Controller_Report
{
	/****
	 * 出差管理
	 */
    public function indexAction()
    {
        $this->_title($this->__('出差管理'));
        $this->loadLayout();
        $this->_setActiveMenu('attendance/travel');
        $this->_addContent($this->getLayout()->createBlock('attendance/adminhtml_travel', 'travel'));
        $this->renderLayout();
    }
	

    public function newAction()
    {
    	$this->_forward('edit');
    }
    
    public function editAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$travel = Mage::getModel('attendance/travel')->load($id);
    	
    	if ($travel->getId()) {
    		//判断归属
    		if ($travel->getData('travel_create')!=$this->_getUser()->getId()) {
    			$this->_getSession()->addError('非法操作！');
    			$this->_redirect('*/*');
    		}
    	}
    	Mage::register('current_travel',$travel);
        
        $this->loadLayout();
        if ($travel->getId()) {
        	$this->_title($this->__('编辑出差申请'));
        } else {
        	$this->_title($this->__('新建出差申请'));
        }
        $this->_setActiveMenu('attendance/travel');
        $this->_addContent($this->getLayout()->createBlock('attendance/adminhtml_travel_edit', 'travel.edit'));
        $this->renderLayout();
    }
    
    /*
     * 保存出差管理
     */
    public function saveAction() {
		$data = $this->getRequest()->getParams();
		$travel = Mage::getModel('attendance/travel');
		if (isset($data['id']) && $data['id']) {
			$travel->load($data['id']);
			if ($travel->getData('travel_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		} else {
			$data['travel_create'] = Mage::registry('current_user')->getId();
		}
		unset($data['id']);
        //echo "<xmp>";var_dump($data);die();     
		$data['travel_company'] = Mage::registry('current_company')->getId();
		$data['travel_cdepartment'] = Mage::registry('current_user')->getDepartment()->getId();
		$travel->addData($data);
		try {
			$travel->save();
			$auditOldArr = explode(',',$data['travel_audit_old']);
			$auditArr = explode(',',$data['travel_audit']);
			$ccOldArr = explode(',',$data['travel_cc_old']);
			$ccArr = explode(',',$data['travel_cc']);
			
			$delAuditArr = array_diff($auditOldArr,$auditArr);
			$addAuditArr = array_diff($auditArr,$auditOldArr);
			
			$delCcArr = array_diff($ccOldArr,$ccArr);
			$addCcArr = array_diff($ccArr,$ccOldArr);
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');    
			
			$travelId = $travel->getId();
			$auditType = Mage_Attendance_Model_Fieldwork_Link::LINK_TYPE_TO;
			$auditCc = Mage_Attendance_Model_Fieldwork_Link::LINK_TYPE_CC;
			foreach ($delAuditArr as $v) {
				$v = (int)$v;
				$write->query("delete from attendance_travel_link where link_object='$travelId' and link_type='$auditType' and link_user='$v'");  
			}
			foreach ($addAuditArr as $v) {
				$v = (int)$v;
				$write->query("insert into attendance_travel_link(link_object,link_type,link_user) values('$travelId','$auditType','$v')");  
			}
			
			foreach ($delCcArr as $v) {
				$v = (int)$v;
				$write->query("delete from attendance_travel_link where link_object='$travelId' and link_type='$auditCc' and link_user='$v'");  
			}
			foreach ($addCcArr as $v) {
				$v = (int)$v;
				$write->query("insert into attendance_travel_link(link_object,link_type,link_user) values('$travelId','$auditCc','$v')");  
			}
			
			$this->_getSession()->addSuccess('出差申请保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("出差申请保存失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}
    
    public function viewAction() {
    	$id = (int)$this->getRequest()->getParam('id');
    	$travel = Mage::getModel('attendance/travel')->load($id);
    	Mage::register('current_travel',$travel);
    	if ($travel->getId()) {
    		 $this->_title($this->__('查看出差'));
	        $this->loadLayout();
	        $this->_setActiveMenu('attendance/travel');
	        $this->_addContent($this->getLayout()->createBlock('attendance/adminhtml_travel_view', 'travel.view'));
	        $this->renderLayout();
    	} else {
    		$this->_getSession()->addError('出差记录已不存在，请重试。');
			$this->_redirect('*/*');
    	}
    }
    
    /****************** audit *******************/
    /*
     * 保存审核信息
     */
    public function saveAuditAction() {
		$data = $this->getRequest()->getParams();
		$travel = Mage::getModel('attendance/travel');
		$audit = Mage::getModel('attendance/travel_audit');
		if (isset($data['audit_rei']) && $data['audit_rei']) {
			$travel->load($data['audit_rei']);
			if ($travel->getData('rei_company')!=$this->_getCompanyId()) {
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
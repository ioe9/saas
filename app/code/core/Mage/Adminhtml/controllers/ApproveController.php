<?php
/***
 * 审批管理
 */
class Mage_Adminhtml_ApproveController extends Mage_Adminhtml_Controller_Approve
{
    public function indexAction()
    {
       $this->_forward('todo');
    }
    
    public function todoAction()
    {
        $this->_title($this->__('审批管理'));
        $this->loadLayout();
        $this->_setActiveMenu('approve/todo');
        Mage::register('current_filter','todo');
        $this->_addContent($this->getLayout()->createBlock('approve/adminhtml_apply', 'apply'));
        $this->renderLayout();
    }
	
	
	public function newAction()
    {
        $this->_forward('edit');
    }
    
    public function editAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$apply = Mage::getModel('approve/apply')->load($id);
    	
    	if ($apply->getId()) {
    		//判断归属
    		if ($apply->getData('apply_create')!=$this->_getUser()->getId()) {
    			$this->_getSession()->addError('非法操作！');
    			$this->_redirect('*/*');
    		}
    	}
    	Mage::register('current_apply',$apply);
        
        $this->loadLayout();
        if ($apply->getId()) {
        	$this->_title($this->__('编辑申请'));
        } else {
        	$this->_title($this->__('新建申请'));
        }
        $this->_setActiveMenu('approve/todo');
        $this->_addContent($this->getLayout()->createBlock('approve/adminhtml_apply_edit', 'apply.edit'));
        $this->renderLayout();
    }
    
    
    /*
     * 保存申请
     */
    public function saveAction() {
		$data = $this->getRequest()->getParams();
		$apply = Mage::getModel('approve/apply');
		if (isset($data['id']) && $data['id']) {
			$apply->load($data['id']);
			if ($apply->getData('apply_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		} else {
			$data['apply_create'] = Mage::registry('current_user')->getId();
		}
		unset($data['id']);
        //echo "<xmp>";var_dump($data);die();     
		$data['apply_company'] = Mage::registry('current_company')->getId();
		$apply->addData($data);
		try {
			$apply->save();
			$auditOldArr = explode(',',$data['apply_audit_old']);
			$auditArr = explode(',',$data['apply_audit']);
			$ccOldArr = explode(',',$data['apply_cc_old']);
			$ccArr = explode(',',$data['apply_cc']);
			
			$delAuditArr = array_diff($auditOldArr,$auditArr);
			$addAuditArr = array_diff($auditArr,$auditOldArr);
			
			$delCcArr = array_diff($ccOldArr,$ccArr);
			$addCcArr = array_diff($ccArr,$ccOldArr);
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');    
			
			$applyId = $apply->getId();
			$auditType = Mage_Approve_Model_Apply_Link::LINK_TYPE_TO;
			$auditCc = Mage_Approve_Model_Apply_Link::LINK_TYPE_CC;
			foreach ($delAuditArr as $v) {
				$v = (int)$v;
				$write->query("delete from approve_apply_link where link_apply='$applyId' and link_type='$auditType' and link_user='$v'");  
			}
			foreach ($addAuditArr as $v) {
				$v = (int)$v;
				$write->query("insert into approve_apply_link(link_apply,link_type,link_user) values('$applyId','$auditType','$v')");  
			}
			
			foreach ($delCcArr as $v) {
				$v = (int)$v;
				$write->query("delete from approve_apply_link where link_apply='$applyId' and link_type='$auditCc' and link_user='$v'");  
			}
			foreach ($addCcArr as $v) {
				$v = (int)$v;
				$write->query("insert into approve_apply_link(link_apply,link_type,link_user) values('$applyId','$auditCc','$v')");  
			}
			
			$this->_getSession()->addSuccess('申请保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("申请保存失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}
	
	
    public function viewAction() {
    	$id = (int)$this->getRequest()->getParam('id');
    	$apply = Mage::getModel('approve/apply')->load($id);
    	$back = $this->getRequest()->getParam('back');
    	$back = $back ? $back : 'todo';
    	Mage::register('current_apply',$apply);
    	if ($apply->getId()) {
    		 $this->_title($this->__('查看申请'));
	        $this->loadLayout();
	        $this->_setActiveMenu('approve/'.$back);
	        $this->_addContent($this->getLayout()->createBlock('approve/adminhtml_apply_view', 'apply.view'));
	        $this->renderLayout();
    	} else {
    		$this->_getSession()->addError('申请已不存在，请重试。');
			$this->_redirect('*/*');
    	}
    }
    
    

}
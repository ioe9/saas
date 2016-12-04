<?php
class Mage_Adminhtml_Edm_Client_GroupController extends Mage_Adminhtml_Controller_Edm {
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('client/group');
		$this->_title("客户管理")->_title("客户分组");
		
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_client_group', 'client_group'));
		$this->renderLayout();
	}
	public function listAction() {
		$this->_forward('index');
	}
	public function newAction() {
		$this->_forward('edit');
	}
	public function editAction() {
		$id = $this->getRequest()->getParam('id');
		$group = Mage::getModel('edm/company_client_group')->load($id);
		
		$this->loadLayout();
		
		$this->_setActiveMenu('client/group');
		Mage::register('current_group',$group);
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_client_group_edit', 'client_group_edit'));
       
		$this->renderLayout();
	}
	public function saveAction() {
		$data = $this->getRequest()->getParams();
		$group = Mage::getModel('edm/company_client_group');
		if (isset($data['id']) && $data['id']) {
			$group->load($data['id']);
			if ($group->getId() && $group->getData('group_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作！");
				$this->_redirect('*/*/index');
			}
		} else {
			$data['group_company'] = $this->_getCompanyId();
		}
		unset($data['id']);
		$group->addData($data);
		try {
			$group->save();
			$this->_getSession()->addSuccess('分组保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("分组保存失败，请稍后重试或联系管理员");
		}
		if ($this->getRequest()->getParam('back')) {
    		$this->_redirect('*/*/edit',array('id'=>$group->getId()));
    	} else {
    		$this->_redirect('*/*/index');
    	}

	}
	public function viewAction() {
    	$id = (int)$this->getRequest()->getParam('id');
    	$group = Mage::getModel('edm/company_client_group')->load($id);
    	
    	Mage::register('current_group',$group);
    	if ($group->getId()) {
    		 $this->_title($this->__('查看分组详情'));
	        $this->loadLayout();
	        $this->_setActiveMenu('client/group');
	        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_client_group_view', 'group.view'));
	        $this->renderLayout();
    	} else {
    		$this->_getSession()->addError('分组已不存在，请重试。');
			$this->_redirect('*/*');
    	}
    }
	public function clientgridAction() {
       	$id = (int) $this->getRequest()->getParam('id');
		$model = Mage::getModel('edm/company_client_group');
        if ($id) {
            $model->load($id);
        }
        Mage::register('current_group', $model);
		$this->getResponse()->setBody($this->getLayout()
		  ->createBlock('edm/adminhtml_company_client_group_edit_tab_client','productGrid')->toHtml());
	}
    public function deleteAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$group = Mage::getModel('edm/company_client_group')->load($id);
    	if ($group->getId() && $group->getData('group_company')!=$this->_getCompanyId()) {
			$this->_getSession()->addError("非法操作！");
			$this->_redirect('*/*/index');
		}
    	try {
    		 $group->delete();
    		 $this->_getSession()->addSuccess("分组删除成功");
    	} catch(Exception $e) {
    		$this->_getSession()->addError();
    	}
    	$this->_redirect('*/*/index');
    }
	public function _isAllowed() {
    	return true;
	}
}
<?php
class Mage_Adminhtml_Edm_TaskController extends Mage_Adminhtml_Controller_Edm {
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('task/list');
		$this->_title("任务大厅")->_title("任务列表");
		$this->renderLayout();
	}
	
	public function myAction() {
		$this->loadLayout();
		$this->_setActiveMenu('task/my');
		Mage::register('current_filter','my');
		$this->_title("任务大厅")->_title("我的任务");
		$this->renderLayout();
	}
	
	public function viewAction() {
    	$id = (int)$this->getRequest()->getParam('id');
    	$task = Mage::getModel('edm/task')->load($id);
    	
    	Mage::register('current_task',$task);
    	if ($task->getId()) {
    		 $this->_title($this->__('查看任务详情'));
	        $this->loadLayout();
	        $this->_setActiveMenu('task/list');
	        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_task_view', 'task.view'));
	        $this->renderLayout();
    	} else {
    		$this->_getSession()->addError('任务记录已不存在，请重试。');
			$this->_redirect('*/*');
    	}
    }
	public function _isAllowed() {
    	return true;
	}
}
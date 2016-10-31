<?php
/***
 * 公共类
 */
class Mage_Adminhtml_Controller_Task_Project extends Mage_Adminhtml_Controller_Task {
	protected $_title;
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('task');
		$this->_title($this->_title);
		$this->_addContent($this->getLayout()->createBlock('task/adminhtml_project', 'project'));
		$this->renderLayout();
	}
	public function newAction() {
		$this->_forward('edit');
	}
	public function editAction() {
		$this->loadLayout();
		$this->_setActiveMenu('task');
		$id = $this->getRequest()->getParam('id');
		$project = Mage::getModel('task/project');
		if ($id) {
			$project->load($id);
			if ($project->getId()) {
				//判断归属
			}
		}
		Mage::register('current_project',$project);
		$this->_addContent($this->getLayout()->createBlock('task/adminhtml_project_edit', 'project.edit'));
		$this->renderLayout();
	}
	public function saveAction() {
		$data = $this->getRequest()->getParams();
		$project = Mage :: registry('current_project');
		if (!$project || !$project->getId()) {
			$this->_getSession()->addError('对不起，无效请求！');
			$this->_redirect('*/*/index');
			return;
		}
		$model = Mage :: getModel('task/project');
		try {
			$model->addData($data)->save();
			$this->_getSession()->addSuccess('恭喜您，保存成功！');
		} catch (Exception $e) {
			$this->_getSession()->addError('保存失败，请重试！');
			//失败
		}
		$this->_redirect('*/*/index');
	}
}
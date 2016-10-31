<?php
/***
 * 任务详情
 */
class Mage_Adminhtml_Task_ViewController extends Mage_Adminhtml_Controller_Task {
	
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('task');
		$this->_title($this->_title);
		$this->_addContent($this->getLayout()->createBlock('task/adminhtml_task_view', 'task_view'));
		$this->renderLayout();
	}
}
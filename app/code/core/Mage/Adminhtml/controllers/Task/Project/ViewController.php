<?php
/***
 * 项目详情
 */
class Mage_Adminhtml_Task_Project_ViewController extends Mage_Adminhtml_Controller_Task_Project {
	
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('task');
		$this->_title($this->_title);
		$this->_addContent($this->getLayout()->createBlock('task/adminhtml_project_view', 'project.view'));
		$this->renderLayout();
	}
}
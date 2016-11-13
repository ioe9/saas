<?php
/***
 * 应用设置
 */
class Mage_Adminhtml_Bill_SettingController extends Mage_Adminhtml_Controller_Report
{
	/****
	 * 应用设置
	 */
    public function indexAction()
    {
        $this->_title($this->__('应用管理'));
        $this->loadLayout();
        $this->_setActiveMenu('bill/setting');
        $this->_addContent($this->getLayout()->createBlock('bill/adminhtml_setting', 'setting'));
        $this->renderLayout();
    }
	

	
	public function saveTypeAction()
	{
		$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
		$typeName = trim($this->getRequest()->getParam('type_name'));
		$type = Mage::getModel('bill/setting_type');
		$data = array(
			'type_company' => $this->_getCompanyId(),
			'type_name' => $typeName,
		);
		$type->addData($data);
		
		try {
			$type->save();
		} catch (Exception $e) {
			$res['succeed'] = false;
			$res['msg'] = "保存失败，请重试。";
		}
		
		echo json_encode($res);
	}
	
	public function saveProjectAction()
	{
		$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
		$projectName = trim($this->getRequest()->getParam('project_name'));
		$project = Mage::getModel('bill/setting_project');
		$data = array(
			'project_company' => $this->_getCompanyId(),
			'project_name' => $projectName,
		);
		$project->addData($data);
		
		try {
			$project->save();
		} catch (Exception $e) {
			$res['succeed'] = false;
			$res['msg'] = "保存失败，请重试。";
		}
		
		echo json_encode($res);
	}
	
		public function deleteTypeAction()
	{
		$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
		$typeId = (int)$this->getRequest()->getParam('id');
		$type = Mage::getModel('bill/setting_type')->load($typeId);
		if ($type->getId()) {
			if ($type->getData('type_company')==$this->_getCompanyId()) {
				//权限检查 TODO...
				try {
					$type->delete();
				} catch (Exception $e) {
					$res['succeed'] = false;
				}
			} else {
				$res['succeed'] = false;
				$res['msg'] = "非法操作！";
			}
		} else {
			$res['succeed'] = false;
			$res['msg'] = "记录已不存在，请确认。";
		}
		echo json_encode($res);
	}
	
	
	public function deleteProjectAction()
	{
		$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
		$projectId = (int)$this->getRequest()->getParam('id');
		$project = Mage::getModel('bill/setting_project')->load($projectId);
		if ($project->getId()) {
			if ($project->getData('project_company')==$this->_getCompanyId()) {
				//权限检查 TODO...
				try {
					$project->delete();
				} catch (Exception $e) {
					$res['succeed'] = false;
				}
			} else {
				$res['succeed'] = false;
				$res['msg'] = "非法操作！";
			}
		} else {
			$res['succeed'] = false;
			$res['msg'] = "记录已不存在，请确认。";
		}
		echo json_encode($res);
	}
}
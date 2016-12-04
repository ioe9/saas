<?php
class Mage_Adminhtml_Setting_TreeController extends Mage_Adminhtml_Controller_Dashboard
{
	/**
	 * 获取部门树数据
	 */
	public function getDeptDataAction() {
		$data = Mage::getModel('admin/department')->getDeptData();
    	echo json_encode($data);
	}
	
	/**
	 * 获取员工树数据
	 */
    public function getStaffDataAction() {
    	$data = Mage::getModel('admin/department')->getUserData();
    	echo json_encode($data);
    }
    
    /***
     * 获取部门选择树
     */
    public function getDeptChooserAction() {
    	$this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('adminhtml/setting_tree_department_chooser', 'setting_tree_department_chooser')->toHtml()
        );
    }
    public function getStaffChooserAction() {
    	$this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('adminhtml/setting_tree_user_chooser', 'setting_tree_user_chooser')->toHtml()
        );
    }
    
    protected function _isAllowed()
    {
        return true;
    }
}

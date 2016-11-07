<?php
class Mage_Adminhtml_Setting_TreeController extends Mage_Adminhtml_Controller_Dashboard
{
	/**
	 * 获取部门树数据
	 */
	public function getDeptDataAction() {
		
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

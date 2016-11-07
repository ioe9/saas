<?php
/***
 * 系统设置 - 组织结构设置
 */
class Mage_Adminhtml_Setting_OrganizationController extends Mage_Adminhtml_Controller_Setting
{
    public function indexAction()
    {
        $this->_title($this->__('组织结构设置'));
        $this->loadLayout();
        $this->_setActiveMenu('setting/organization');
        $this->_addContent($this->getLayout()->createBlock('adminhtml/setting_organization', 'setting.organization'));
        $this->renderLayout();
    }
    
    

    
    /***
     * 获取所有部门列表，一维数组
     */
    public function getDeptListAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
    	$treeNode = Mage::getModel('admin/department')->getDeptList();
    	$res['data'] = $treeNode;
    	echo json_encode($res);
    	
    }
    /***
     * 获取部门列表
     */
	public function departDataWithCompanyNameAction() {
		$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
    	$treeNode = Mage::getModel('admin/department')->getOrgTree();
    	$res['data'] = $treeNode;
    	echo json_encode($treeNode);
	}
    
    /***
     * 新增部门
     */
    public function addDeptAction() {
    	$department = Mage::getModel('admin/department');
    	Mage::register('current_department',$department);
    	$this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('adminhtml/setting_organization_department_form', 'setting_organization_department_form')->toHtml()
        );
    }
    /***
     * 新增部门保存
     */
    public function addDeptSaveAction() {
		$res = array(
			'succeed'=>true,
			'code' => -1,
		);
		$parentId = (int)$this->getRequest()->getParam('parentId',-1);
		$depName = trim($this->getRequest()->getParam('deptName'));
		$depCode = $this->getRequest()->getParam('deptCode');
    	$department = Mage::getModel('admin/department');
    	$isRoot = true;
    	if ($depName) {
    		if ($parentId) {
	    		//非一级部门
	    		$depParent = Mage::getModel('admin/department')->load($parentId);
	    		if ($depParent->getId()) {
	    			$isRoot = false;
	    		}
	    	}
	    	$data = array(
	    		'dep_name' => $depName,
	    		'dep_code' => $depCode,
	    		'dep_company' => Mage::registry('current_company')->getId(),
	    	);
	    	if ($isRoot) {
	    		$data['dep_parent'] = 0;
	    		$data['dep_level'] = 0;
	    	} else {
	    		$data['dep_parent'] = $depParent->getId();
	    		$data['dep_level'] = $depParent->getDepLevel()+1;
	    	}
	    	$department->addData($data);
	    	try {
	    		$department->save();
	    		if ($isRoot) {
	    			$department->setDepPath($department->getId().'/');
	    		} else {
	    			$department->setDepPath($depParent->getDepPath().$department->getId().'/');
	    		}
	    		$department->save();
	    	} catch (Exception $e) {
	    		$res['succeed'] = false;
	    		$res['msg'] = "无法保存，请重试或联系管理员。";
	    	}
    	} else {
    		$res['succeed'] = false;
    		$res['msg'] = "部门名称不能为空，请重试。";
    	}
	    	
    	
    	echo json_encode($res);
    }
    
    /***
     * 编辑部门
     */
    public function editDeptAction() {
    	$departmentId = (int)$this->getRequest()->getParam('deptId');
    	$department = Mage::getModel('admin/department')->load($departmentId);
    	if (!$department->getId() || $department->getDepCompany()!=Mage::registry('current_company')->getId()) {
    		$department = Mage::getModel('admin/department');
    	}
    	Mage::register('current_department',$department);
    	$this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('adminhtml/setting_organization_department_form', 'setting_organization_department_form')->toHtml()
        );
    }
    /***
     * 编辑部门保存
     */
    public function editDeptSaveAction() {
		$res = array(
			'succeed'=>true,
			'code' => -1,
		);
		$parentId = (int)$this->getRequest()->getParam('parentId',-1);
		$depId = (int)$this->getRequest()->getParam('deptId');
		$depName = trim($this->getRequest()->getParam('deptName'));
		$depCode = $this->getRequest()->getParam('deptCode');
    	$department = Mage::getModel('admin/department')->load($depId);
    	$isRoot = true;
    	if ($depName && $department->getId() && $department->getDepCompany()==Mage::registry('current_company')->getId()) {
    		if ($parentId) {
	    		//非一级部门
	    		$depParent = Mage::getModel('admin/department')->load($parentId);
	    		if ($depParent->getId()) {
	    			$isRoot = false;
	    		}
	    	}
	    	$data = array(
	    		'dep_name' => $depName,
	    		'dep_code' => $depCode,
	    	);
	    	if ($isRoot) {
	    		$data['dep_parent'] = 0;
	    		$data['dep_level'] = 0;
	    	} else {
	    		$data['dep_parent'] = $depParent->getId();
	    		$data['dep_level'] = $depParent->getDepLevel()+1;
	    	}
	    	$department->addData($data);
	    	try {
	    		$department->save();
	    		if ($isRoot) {
	    			$department->setDepPath($department->getId().'/');
	    		} else {
	    			$department->setDepPath($depParent->getDepPath().$department->getId().'/');
	    		}
	    		$department->save();
	    	} catch (Exception $e) {
	    		$res['succeed'] = false;
	    		$res['msg'] = "无法保存，请重试或联系管理员。";
	    	}
    	} else {
    		$res['succeed'] = false;
    		$res['msg'] = "部门名称不能为空，请重试。";
    	}
	    	
    	
    	echo json_encode($res);
    }
    
    public function delDeptAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1
		);
    	$departmentId = (int)$this->getRequest()->getParam('deptId');
    	$department = Mage::getModel('admin/department')->load($departmentId);
    	if ($department->getId() && $department->getDepCompany()==$this->_getCompanyId()) {
    		try {
    			$department->delete();
    		} catch (Exception $e) {
    			$res['succeed'] = false;
    			$res['msg'] = '删除失败，请重试或联系管理员。';
    		}
    	} else {
    		$res['succeed'] = false;
			$res['msg'] = '非法操作。';
    	}
    	echo json_encode($res);
    }
    /**
     * 获取部门树
     */
    public function getOrgTreeAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
    	$treeNode = Mage::getModel('admin/department')->getOrgTree();
    	$res['data'] = $treeNode;
    	echo json_encode($res);
    }
    
    public function countStaffAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
		$count = Mage::getModel('admin/department')->getAllUser()
    			->getSize();
		$res['data'] = $count;
    	echo json_encode($res);
    }
    public function loadStaffAction() {
    	$this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('adminhtml/setting_organization_users', 'setting_organization_users')->toHtml()
        );
    }
    
    /***
     * 统计Tree节点的用户数
     */
    public function countUserByTreeNodeAction() {
    	$parentId = (int)$this->getRequest()->getParam('id',-1);
    	$type = (int)$this->getRequest()->getParam('type');
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
    	if ($parentId==-1 && $type==0) {
    		//全公司
    		$count = Mage::getModel('admin/department')->getAllUser()
    			->getSize();
    		
    	} else if ($parentId>0 && $type==1) {
    		//指定部门
    		$count = Mage::getModel('admin/department')->getUserByTreeNode($parentId)
    			->getSize();
    	}
    	$res['data'] = $count;
    	echo json_encode($res);
    }
    /***
     * 根据Tree节点的用户列表
     */
    public function getUserListByTreeNodeAction() {
    	
    	
    	$this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('adminhtml/setting_organization_users', 'setting_organization_users')->toHtml()
        );
    }
    
    
    /***************************************** 员工 ***********************/
    /***
     * 新增员工
     */
    public function addUserAction() {
    	$department = Mage::getModel('admin/department');
    	Mage::register('current_department',$department);
    	$this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('adminhtml/setting_organization_user_form', 'setting_organization_user_form')->toHtml()
        );
    }
    /***
     * 新增员工保存
     */
    public function addUserSaveAction() {
		$res = array(
			'succeed'=>true,
			'code' => -1,
		);
		$userDepartment = (int)$this->getRequest()->getParam('staffdepts',-1);
		$userTitle = trim($this->getRequest()->getParam('staffdutys'));
		$name = trim($this->getRequest()->getParam('staffnames'));
    	$username = trim($this->getRequest()->getParam('staffphones'));
		$user = Mage::getModel('admin/user');
    	if ($username && $name) {
    		
	    	$data = array(
	    		'name' => $name,
	    		'username' => $username,
	    		'is_active' => 0,
	    		'user_company' => $this->_getCompanyId(),
	    		'user_title' => $userTitle,
	    		'user_department' => $userDepartment,
	    	);
	    	
	    	$user->addData($data);
	    	try {
	    		$user->save();
	    	} catch (Exception $e) {
	    		
	    		$res['succeed'] = false;
	    		//$res['msg'] = "无法保存，请重试或联系管理员。";
	    		$res['msg'] = $e->getMessage();
	    	}
    	} else {
    		$res['succeed'] = false;
    		$res['msg'] = "姓名和手机都不能为空，请重试。";
    	}
    	echo json_encode($res);
    }
    
    /***
     * 编辑员工
     */
    public function editUserAction() {
    	$userId = (int)$this->getRequest()->getParam('userId');
    	$user = Mage::getModel('admin/user')->load($userId);
    	if ($user->getId() && $user->getUserCompany()==Mage::registry('current_company')->getId()) {
    		Mage::register('current_staff',$user);
	    	$this->getResponse()->setBody(
	            $this->getLayout()
	                ->createBlock('adminhtml/setting_organization_user_setting', 'setting_organization_user_setting')->toHtml()
	        );
    	} else {
    		$this->getResponse()->setBody("该员工已不存在，请重试。");
    	}
	    	
    }
    /***
     * 编辑员工保存
     */
    public function editUserSaveAction() {
		$res = array(
			'succeed'=>true,
			'code' => -1,
		);
		$userTitle = trim($this->getRequest()->getParam('duty'));
		$depId = trim($this->getRequest()->getParam('userdept'));
		$isAdmin = $this->getRequest()->getParam('ismanage',0);
    	$userId = $this->getRequest()->getParam('userid',0);
    	$user = Mage::getModel('admin/user')->load($userId);
    	if ($user->getId() && $user->getData('user_company')==$this->_getCompanyId()) {
    		$data = array(
	    		'is_admin' => $isAdmin,
	    		'user_title' => $userTitle,
	    		'user_department' => $depId,
	    	);
	    	
	    	$user->addData($data);
	    	try {
	    		$user->save();
	    	} catch (Exception $e) {
	    		
	    		$res['succeed'] = false;
	    		//$res['msg'] = "无法保存，请重试或联系管理员。";
	    		$res['msg'] = $e->getMessage();
	    	}
    	} else {
    		$res['succeed'] = false;
    		$res['msg'] = "无效请求，请重试。";
    	}
    		
	    	
    	
    	echo json_encode($res);
    }
    
    /***
     * 移除员工
     */
    public function delUserAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
		);
		
    	$userId = $this->getRequest()->getParam('userid',0);
    	$user = Mage::getModel('admin/user')->load($userId);
    	if ($user->getId() && $user->getData('user_company')==$this->_getCompanyId()) {
    		
	    	try {
	    		$user->delete();
	    	} catch (Exception $e) {
	    		
	    		$res['succeed'] = false;
	    		$res['msg'] = "移除失败，请重试或联系管理员。";
	    		//$res['msg'] = $e->getMessage();
	    	}
    	} else {
    		$res['succeed'] = false;
    		$res['msg'] = "无效请求，请重试。";
    	}
    		
	    	
    	
    	echo json_encode($res);
    }
    
    /****
     * 搜索员工 - 总数
     */
    public function countSearchUserAction() {
    	$q = trim($this->getRequest()->getParam('name'));
		$type = (int)$this->getRequest()->getParam('type');
		$parentId = (int)$this->getRequest()->getParam('id',-1);
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
    	if ($parentId==-1 && $type==0) {
    		//全公司
    		$count = Mage::getModel('admin/department')->getAllUser()
    			->addFieldToFilter('name',array('like'=>'%'.$q.'%'))
    			->getSize();
    		
    	} else if ($parentId>0 && $type==1) {
    		//指定部门
    		$count = Mage::getModel('admin/department')->getUserByTreeNode($parentId)
    			->addFieldToFilter('name',array('like'=>'%'.$q.'%'))
    			->getSize();
    	}
    	$res['data'] = $count;
    	echo json_encode($res);
    }
    
    /****
     * 搜索员工
     */
    public function searchUserAction() {
    	$this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('adminhtml/setting_organization_users', 'setting_organization_users')->toHtml()
        );
    }
    

    
}
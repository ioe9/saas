<?php
class Mage_Admin_Model_Department extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('admin/department');
    }
    public function getDepartmentCollection() {
    	return $this->getCollection()
    		->addFieldToFilter('dep_company',Mage::registry('current_company')->getId());
    }
    public function getDeptList() {
    	$data = array(array('id'=>-1,'name'=>Mage::registry('current_company')->getCompanyName()));
    	$collection = $this->getDepartmentCollection();
    	foreach ($collection as $item) {
    		$tmp = array(
    			'id' => $item->getId(),
    			'name' => $item->getDepName(),
    		);
    		array_push($data, $tmp);
    	}
    	return $data;
    }
    /****
     * 获取组织结构
     * todo: 名称后面跟员工数量
     */
    public function getOrgTree() {
    	$data = array();
    	foreach ($this->getDepartmentCollection() as $item) {
    		$data[$item->getId()] = $item->getData();
    	}
    	$tree = array(
    		'id' => '-1',
    		'name' => Mage::registry('current_company')->getCompanyName(),
    		'text' => Mage::registry('current_company')->getCompanyName(),
    		'pid' => '0',
    		'open' => 'true',
    		'type' => 'root',
    		'state' => null,
    		'children' => $this->_createTree($data,-1,0),
    	);
    	//echo "<xmp>";var_dump($tree);echo "</xmp>";die();
    	return $tree;
    }
    protected function _createTree($data,$parentId,$i=0) {
    	$childrenTree = null;
    	if (count($data)) {
    		$childrenTree = array();
    	}
    	foreach ($data as $key => $item) {
    		if ($i==0) {
    			if ($item['dep_parent']!=0) {
    				continue;
    			}
    		} else {
    			if ($item['dep_parent']!=$parentId) {
    				continue;
    			}
    		}
    		$curTree = array(
	    		'id' => $key,
	    		'name' => $item['dep_name'],
	    		'text' => $item['dep_name'],
	    		'pid' => $parentId,
	    		'open' => null,
	    		'type' => 'dept',
	    		'state' => null,
	    		'children' => null,
	    	);
    		$childrenData = $this->_getChildren($key, $data);
    		$_childrenTree = array();
    		if (count($childrenData)) {
    			foreach ($childrenData as $_key=>$_item) {
    				$_curTree = array(
			    		'id' => $key,
			    		'name' => $_item['dep_name'],
			    		'text' => $_item['dep_name'],
			    		'pid' => $parentId,
			    		'open' => null,
			    		'type' => 'dept',
			    		'state' => null,
			    		'children' => null,
			    	);
    				$_itemTreeChildren = $this->_createTree($data,$_key,$i+1);
    				$_curTree['children'] = $_itemTreeChildren;
    				array_push($_childrenTree, $_curTree);
    				
    			}
    		}
    		$curTree['children'] = $_childrenTree;
    		array_push($childrenTree, $curTree);
    	}
    	return $childrenTree;
    	
    }
    protected function _getChildren($parentId,$data) {
    	$children = array();
    	foreach ($data as $key => $item) {
    		if ($item['dep_parent']==$parentId) {
    			$children[$item['department_id']] = $item;
    		}
    	}
    	return $children;
    }
    
    public function getAllUser($excludeLeave = true) {
    	$collection = Mage::getModel('admin/user')->getUserByCompany(null,$excludeLeave);
    	return $collection;
    }
    /***
     * 获取部门节点员工
     */
    public function getUserByTreeNode($parentId) {
    	$parentDep = Mage::getModel('admin/department')->load($parentId);
    	$collection = $this->getDepartmentCollection()
    		->addFieldToFilter('dep_path',array('like'=>$parentDep->getData('dep_path')));
		$departmentIds = $collection->getAllIds();
		$depUserCollection = Mage::getModel('admin/user')->getUserByCompany()
			->addFieldToFilter('user_department',array('in'=>$departmentIds));
		return $depUserCollection;
		
    }
    /***
     * 获取部门数据
     */
    public function getDeptData() {
    	$data = array();
    	foreach ($this->getDepartmentCollection() as $item) {
    		$data[$item->getId()] = $item->getData();
    	}
    	
    	$tree = array(
    		'id' => '-1',
    		'name' => Mage::registry('current_company')->getCompanyName(),
    		'open' => 'true',
    		'type' => '1',
    		'nocheck' => true,
    		'state' => null,
    		'children' => $this->_createDeptData($data,-1,0),
    	);
    	return $tree;
    }
    
    protected function _createDeptData($data,$parentId,$i=0) {
    	$childrenTree = null;
    	if (count($data)) {
    		$childrenTree = array();
    	}
    	foreach ($data as $key => $item) {
    		if ($i==0) {
    			if ($item['dep_parent']!=0) {
    				continue;
    			}
    		} else {
    			if ($item['dep_parent']!=$parentId) {
    				continue;
    			}
    		}
    		$curTree = array(
	    		'id' => $key,
	    		'name' => $item['dep_name'],
	    		'type' => '2',
	    		'nocheck' => true,
	    		'children' => null,
	    	);
    		$childrenData = $this->_getChildren($key, $data);
    		
    		$_childrenTree = array();
    		
    		
    		if (count($childrenData)) {
    			foreach ($childrenData as $_key=>$_item) {
    				$_curTree = array(
			    		'id' => $key,
			    		'name' => $_item['dep_name'],
			    		'nocheck' => true,
			    		'type' => '2',
			    		'children' => null,
			    	);
    				$_itemTreeChildren = $this->_createUserData($data,$_key,$i+1);
    				$_curTree['children'] = $_itemTreeChildren;
    				array_push($_childrenTree, $_curTree);
    				
    			}
    		}
    		$curTree['children'] = $_childrenTree;
    		array_push($childrenTree, $curTree);
    	}
    	return $childrenTree;
    	
    }
    /***
     * 获取员工数数据
     */
    public function getUserData() {
    	$data = array();
    	foreach ($this->getDepartmentCollection() as $item) {
    		$data[$item->getId()] = $item->getData();
    	}
    	$dataUser = array();
    	$userCollection = Mage::getModel('admin/user')->getUserByCompany();
    	foreach ($userCollection as $item) {
    		$dataUser[$item->getId()] = $item->getData();
    	}
    	$tree = array(
    		'id' => '-1',
    		'name' => Mage::registry('current_company')->getCompanyName(),
    		'open' => 'true',
    		'type' => '1',
    		'nocheck' => true,
    		'state' => null,
    		'children' => $this->_createUserData($data,$dataUser,-1,0),
    	);
    	return $tree;
    }
    
    protected function _createUserData($data,$dataUser,$parentId,$i=0) {
    	$childrenTree = null;
    	if (count($data)) {
    		$childrenTree = array();
    	}
    	foreach ($data as $key => $item) {
    		if ($i==0) {
    			if ($item['dep_parent']!=0) {
    				continue;
    			}
    		} else {
    			if ($item['dep_parent']!=$parentId) {
    				continue;
    			}
    		}
    		$curTree = array(
	    		'id' => $key,
	    		'name' => $item['dep_name'],
	    		'type' => '2',
	    		'nocheck' => true,
	    		'children' => null,
	    	);
    		$childrenData = $this->_getChildren($key, $data);
    		$childrenDataUser = $this->_getChildrenUser($key,$dataUser);
    		$_childrenTree = array();
    		
    		if (count($childrenDataUser)) {
    			foreach ($childrenDataUser as $_key=>$_item) {
    				$_curTree = array(
			    		'id' => $_item['user_id'],
			    		'name' => $_item['name'],
			    		'icon' => $_item['user_avatar'] ? $_item['user_avatar'] : Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'adminhtml/default/default/images/avatar/avatar_l.png',
			    		'type' => '3',
			    	);
    				array_push($_childrenTree, $_curTree);
    				
    			}
    		}
    		
    		if (count($childrenData)) {
    			foreach ($childrenData as $_key=>$_item) {
    				$_curTree = array(
			    		'id' => $key,
			    		'name' => $_item['dep_name'],
			    		'nocheck' => true,
			    		'type' => '2',
			    		'children' => null,
			    	);
    				$_itemTreeChildren = $this->_createUserData($data,$dataUser,$_key,$i+1);
    				$_curTree['children'] = $_itemTreeChildren;
    				array_push($_childrenTree, $_curTree);
    				
    			}
    		}
    		$curTree['children'] = $_childrenTree;
    		array_push($childrenTree, $curTree);
    	}
    	return $childrenTree;
    	
    }
    
    protected function _getChildrenUser($departmentId,$data) {
    	$users = array();
    	foreach ($data as $key => $item) {
    		if ($item['user_department']==$departmentId) {
    			$users[$item['user_id']] = $item;
    		}
    	}
    	return $users;
    }
    
    public function getAsOptions() {
    	$collection = $this->getDepartmentCollection();
    	$arr = array();
    	foreach ($collection as $item) {
    		$arr[$item->getId()] = $item->getDepName();
    	}
    	return $arr;
    }
}

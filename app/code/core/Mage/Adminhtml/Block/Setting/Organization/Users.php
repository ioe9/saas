<?php
class Mage_Adminhtml_Block_Setting_Organization_Users extends Mage_Adminhtml_Block_Template {
	protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('setting/organization/users.phtml');
    }
    
    public function getUserCollection() {
    	$departmentId = (int)$this->getRequest()->getParam('id',-1);
    	$type = (int)$this->getRequest()->getParam('type');
    	$begin = (int)$this->getRequest()->getParam('begin');
    	$length = (int)$this->getRequest()->getParam('length');
    	$q = trim($this->getRequest()->getParam('name'));
    	if ($departmentId>-1) {
    		
    		$collection = Mage::getModel('admin/department')->getUserByTreeNode($departmentId);
    	} else {
    		$collection = Mage::getModel('admin/department')->getAllUser();
    	}
    	$collection->addFieldToFilter('name',array('like'=>'%'.$q.'%'));
    	$collection->getSelect()
    		->joinLeft(
    			array('dep'=>'saas_admin_department'),
				'main_table.user_department=dep.department_id',
				array('dep_name')
			);
    	$collection->setPageSize($length)
    		->setCurPage(($begin/$length)-1);
    	//echo $collection->getSelect();
		return $collection;
    		
    }
}
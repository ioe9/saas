<?php
class Mage_Document_Block_Adminhtml_Dir_Grid extends Mage_Adminhtml_Block_Template
{
    /**
     * Define Form settings
     *
     */
    public function __construct()
    {
        parent::__construct();
        
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->setTemplate('document/dir/grid.phtml');
    }
    
    
    public function getDirs() {
    	$dirPath = Mage::helper('document')->getCompanyDocumentRoot();
    	$dirParent = Mage::registry('current_dir_parent');
    	$dirParentId = $dirParent->getId() ? $dirParent->getId() : 0;
    	
    	/************************ 处理权限问题 **********************/
    	$linkCollection = Mage::getResourceModel('document/dir_link_collection');
    	$linkCollection->getSelect()->join(
    		array('dir'=>'document_dir'),
    		'main_table.link_dir=dir.dir_id',
    		array('dir_id','dir_path')
		);	
    		//->addFieldToFilter('dir_company',Mage::registry('current_company')->getId())
    	$linkCollection->addFieldToFilter('visible_scope',0);
		if ($dirParentId) {
			$linkCollection->addFieldToFilter('dir_parent',$dirParentId);
		} else {
			$linkCollection->addFieldToFilter('dir_parent',0);
		}
    	$dirCollection = Mage::getResourceModel('document/dir_collection');
    	$dirCollection->addFieldToFilter('dir_company',Mage::registry('current_company')->getId());
    	if ($dirParentId) {
			$dirCollection->addFieldToFilter('dir_parent',$dirParentId);
		} else {
			$dirCollection->addFieldToFilter('dir_parent',0);
		}
		$dirCollection->getSelect()->join(
    		array('u'=>'saas_admin_user'),
    		'main_table.dir_create=u.user_id',
    		array('name as username')
		);	

		//echo $dirCollection->getSelect();
    	$arr = array();
    	$dirIdArr = $dirCollection->getAllIds();
    	$wishCollection = Mage::getResourceModel('document/wish_collection')
    		->addFieldToFilter('wish_create',Mage::registry('current_user')->getId())
    		->addFieldToFilter('wish_dir',array('id'=>$dirIdArr));
    	$wishIdArr = array();
    	foreach ($wishCollection as $item) {
    		array_push($wishIdArr,$item->getData('wish_dir'));
    	}
    	foreach ($dirCollection as $item) {
    		$hasPri = true;
    		if (Mage::registry('current_user')->getId()!=$item->getData('dir_create')) {
    			if ($item->getData('visible_scope')==0) {
	    			$hasPri = $this->hasPri($linkCollection,$item->getData('dir_path'));
	    		} else {
	    			$hasPri = false;
	    		}
    			
    		}
	    		
    		
    		$tmp = array(
    			'id' => $item->getData('dir_id'),
    			'name' => $item->getData('dir_name'),
    			'hasPri' => $hasPri,
    			'wish' => (in_array($item->getData('dir_id'),$wishIdArr)) ? true : false,
    		);
    		$tmp = array_merge($tmp,$item->getData());
    		array_push($arr, $tmp);
    	}
    	//echo "<xmp>";var_dump($arr); echo "</xmp>";

    	return $arr;
    }
    
    public function hasPri($linkCollection,$dir) {
    	$flag = false;
    	
    	foreach ($linkCollection as $item) {
    		if ($item->getData('dir_path')==$dir) {
    			$objectId = $item->getData('link_object');
    			if ($item->getData('link_type')==Mage_Document_Model_Dir_Link::LINK_TYPE_DEPT) {
	    			//部门，判断是否当前部门
	    			$depId = Mage::registry('current_user')->getUserDepartment();
	    			//var_dump($depId);
	    			if ($depId == $objectId) {
	    				$flag = true;
	    			}
	    		} else if ($item->getData('link_user')==Mage_Document_Model_Dir_Link::LINK_TYPE_USER) {
	    			$userId = Mage::registry('current_user')->getId();
	    			if ($userId == $objectId) {
	    				$flag = true;
	    			}
	    		}
    		}
	    		
    	}
    	return $flag;
    }
}

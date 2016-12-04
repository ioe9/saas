<?php
/***
 * 文档管理
 */
class Mage_Adminhtml_DocumentController extends Mage_Adminhtml_Controller_Document
{
    public function indexAction()
    {
        $this->_forward('dir');
    }
    
    public function dirAction()
    {
    	$dirParentId = trim($this->getRequest()->getParam('dir_parent'));
        
    	$dirParent = Mage::getModel('document/dir');
    	if ($dirParentId) {
    		$dirParent->load($dirParentId);
    	}
    	
    	Mage::register('current_dir_parent',$dirParent);
        $this->_title($this->__('文件目录'));
        $this->loadLayout();
        $this->_setActiveMenu('document/dir');
        $this->_addContent($this->getLayout()->createBlock('document/adminhtml_dir', 'dir'));
        $this->renderLayout();
    }
    
    public function recentAction()
    {
    	$dirParentId = trim($this->getRequest()->getParam('dir_parent'));
        
    	$dirParent = Mage::getModel('document/dir');
    	if ($dirParentId) {
    		$dirParent->load($dirParentId);
    	}
    	Mage::register('current_filter','recent');
    	Mage::register('current_dir_parent',$dirParent);
        $this->_title($this->__('文件目录'));
        $this->loadLayout();
        $this->_setActiveMenu('document/recent');
        $this->_addContent($this->getLayout()->createBlock('document/adminhtml_dir', 'dir'));
        $this->renderLayout();
    }
    
    public function wishAction()
    {
    	$dirParentId = trim($this->getRequest()->getParam('dir_parent'));
        
    	$dirParent = Mage::getModel('document/dir');
    	if ($dirParentId) {
    		$dirParent->load($dirParentId);
    	}
    	Mage::register('current_filter','wish');
    	Mage::register('current_dir_parent',$dirParent);
        $this->_title($this->__('文件目录'));
        $this->loadLayout();
        $this->_setActiveMenu('document/wish');
        $this->_addContent($this->getLayout()->createBlock('document/adminhtml_dir', 'dir'));
        $this->renderLayout();
    }
    
    /***
     * 动态获取目录列表
     */
    public function loadDirAction()
    {
        $dirParentId = trim($this->getRequest()->getParam('dir_parent'));
        
    	$dirParent = Mage::getModel('document/dir');
    	if ($dirParentId) {
    		$dirParent->load($dirParentId);
    	}
    	
    	Mage::register('current_dir_parent',$dirParent);
    	$this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('document/adminhtml_dir_grid', 'adminhtml_dir_grid')->toHtml()
        );
    }
    public function loadCreateDirAction() {
    	$dirParentId = trim($this->getRequest()->getParam('dir_parent'));
        $dirId = trim($this->getRequest()->getParam('dir_id'));
    	$dir = Mage::getModel('document/dir');
    	$dirParent = Mage::getModel('document/dir');
    	if ($dirParentId) {
    		$dirParent->load($dirParentId);
    	}
    	if ($dirId) {
    		$dir->load($dirId);
    	}
    	Mage::register('current_dir',$dir);
    	Mage::register('current_dir_parent',$dirParent);
    	$this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('document/adminhtml_dir_form', 'adminhtml_dir_form')->toHtml()
        );
    }
    
    public function loadMovetoDirAction() {
    	$dirParentId = (int)$this->getRequest()->getParam('id',0);
       
    	$dirParent = Mage::getModel('document/dir');
    	if ($dirParentId) {
    		$dirParent->load($dirParentId);
    	}
    	
		$collection = Mage::getResourceModel('document/dir_collection')
			->addFieldToFilter('dir_company',$this->_getCompanyId())
			->addFieldToFilter('is_file',0);
		
		$collection->addFieldToFilter('dir_parent',$dirParentId);
		
		$arr = array();
		foreach ($collection as $item) {
			$tmp = array(
				"id" => $item->getData('dir_id'),
			     "name" => $item->getData('dir_name'),
			     "pid" => $item->getData('dir_parent'),
			     "isParent" => "true",
			     "iconSkin" => "fIcon",
			);
			array_push($arr, $tmp);
		}
		if (!$dirParentId) {
			$result = array("id"=>"1",
					   "name"=>"文件目录",
					   "open"=>"true",
					   "isParent"=>"true",
					   "iconSkin"=>"fIcon",
					   "children" => $arr
		   );
		} else {
			$result = $arr;
		   
		}
		
		echo json_encode($result);
    }
    
    /***
     * 保存目录
     */
    public function saveDirAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
    	$data = $this->getRequest()->getParams();
    	$parentDirId = $data['parent_dir'];
    	$dirId = trim($this->getRequest()->getParam('id'));
    	$dir = Mage::getModel('document/dir');
    	$dirParent = Mage::getModel('document/dir');
    	$pathUniq = '';
    	if ($dirId) {
    		$dir->load($dirId);
    	} else {
    		$pathUniq = $this->getUniqId;
    		$data['level_path'] = null;
    		$data['dir_create'] = Mage::registry('current_user')->getId();
    		$data['dir_company'] = $this->_getCompanyId();
    		if ($parentDirId) {
	    		$dirParent->load($parentDirId);
	    		$data['dir_parent'] = $parentDirId;
	    		$data['level_path'] = ($dirParent->getData('level_path') ? $dirParent->getData('level_path').'/'.$parentDirId : $parentDirId);
	    	}
    	}
	    	
    	$dir->addData($data);
		try {
			//生成目录
			$dir->save();
			
    		$res['data'] = $dir->getData();
    		$deptOldArr = explode(',',$data['visible_department_old']);
			$deptArr = explode(',',$data['visible_department']);
			$userOldArr = explode(',',$data['visible_user_old']);
			$userArr = explode(',',$data['visible_user']);
			
			$delDirArr = array_diff($deptOldArr,$deptArr);
			$addDirArr = array_diff($deptArr,$deptOldArr);
			
			$delUserArr = array_diff($userOldArr,$userArr);
			$addUserArr = array_diff($userArr,$userOldArr);
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');    
			
			$dirId = $dir->getId();
			$deptType = Mage_Document_Model_Dir_Link::LINK_TYPE_DEPT;
			$deptUser = Mage_Document_Model_Dir_Link::LINK_TYPE_USER;
			foreach ($delDirArr as $v) {
				$v = (int)$v;
				$write->query("delete from document_dir_link where link_dir='$dirId' and link_type='$deptType' and link_object='$v'");  
			}
			foreach ($addDirArr as $v) {
				$v = (int)$v;
				$write->query("insert into document_dir_link(link_dir,link_type,link_object) values('$dirId','$deptType','$v')");  
			}
			
			foreach ($delUserArr as $v) {
				$v = (int)$v;
				$write->query("delete from document_dir_link where link_dir='$dirId' and link_type='$deptUser' and link_object='$v'");  
			}
			foreach ($addUserArr as $v) {
				$v = (int)$v;
				$write->query("insert into document_dir_link(link_dir,link_type,link_object) values('$dirId','$deptUser','$v')");  
			}
			$res['msg'] = "目录保存成功";
		} catch (Exception $e) {
			//echo $e->getMessage();
			$res['msg'] = "目录保存失败，请联系管理员";
			$res['succeed'] = false;
		}
		
    	echo json_encode($res);
    	
    }
    
    /***
     * 上传文件
     */
    public function uploadFileAction() {
    	$dirParentId = trim($this->getRequest()->getParam('dir_parent'));
    	$dirId = trim($this->getRequest()->getParam('id'));
    	$dirParent = Mage::getModel('document/dir');
    	if ($dirParentId) {
    		$dirParent->load($dirParentId);
    	}
    	Mage::register('current_dir_parent',$dirParent);
    	$this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('document/adminhtml_dir_upload', 'adminhtml_dir_upload')->toHtml()
        );
    }
    /***
     * 保存文件
     */
    public function uploadFileSaveAction() {
    	//公司LOGO
		if(isset($_FILES['Filedata']['name']) && (file_exists($_FILES['Filedata']['tmp_name']))) {  
		    try {  
			    $uploader = new Mage_Core_Model_File_Uploader('Filedata');
			    $allowExt = Mage::helper('document')->getAllowExt();
	            $uploader->setAllowedExtensions($allowExt);
	            $uploader->setAllowRenameFiles(true);
	            $oldFileName = $_FILES['Filedata']['name'];
	            $ext = explode('.',$oldFileName);
	            $fileNamePre = $this->getUniqId();
	            $fileName = $fileNamePre.'.'.$ext[count($ext)-1];

	            $path = Mage::helper('document')->getCompanyDocumentRoot();
	            $result = $uploader->save($path,$fileName);
	            $parentDirId = $this->getRequest()->getParam('dir_parent',0);
	            
	            $dir = Mage::getModel('document/dir');
	            $data['dir_path'] = $fileName;
	            $data['dir_name'] = $oldFileName;
	            $data['is_file'] = 1;
	            $data['file_size'] = sprintf("%.2f",$_FILES['Filedata']['size']/1024);
	            $extNew = Mage::helper('document')->getExt('.'.$ext[count($ext)-1]);
	            $data['file_ext'] = $extNew;
				$data['dir_create'] = Mage::registry('current_user')->getId();
    			$data['dir_company'] = $this->_getCompanyId();

		    	if ($parentDirId) {
		    		$dirParent->load($parentDirId);
		    		$data['dir_parent'] = $dirParent->getData('dir_path');
		    	}
		    	$dir->addData($data);
		    	$dir->save();
				if ($parentDirId) {
					$dirParent->setData('file_size',$dirParent->getData('file_size')+$data['file_size']);
				}
			    echo 1;
		    } catch(Exception $e) {  
		    	echo $e->getMessage();
		    	echo -1; 
		    }  
		} else {
			echo 0;
		}
    	//
    	
    }
    /***
     * 移动文件
     */
    public function movetoAction() {
		
    	$dirId = trim($this->getRequest()->getParam('dir_id'));
    	$dir = Mage::getModel('document/dir');
    	if ($dirId) {
    		$dir->load($dirId);
    		//filesize
    		$dirPath = Mage::helper('document')->getCompanyDocumentRoot();
    		$dir->setData('filesize',filesize($dirPath.$dir->getData('file_path')));
    	}
    	Mage::register('current_dir',$dir);
    	$this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('document/adminhtml_dir_moveto', 'adminhtml_dir_moveto')->toHtml()
        );
    }
    public function movetoSaveAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
    	$dirParentId = intval($this->getRequest()->getParam('dir_parent'));
    	$dirId = intval($this->getRequest()->getParam('id'));
    	$dir = Mage::getModel('document/dir');
    	$dirParent = Mage::getModel('document/dir');
    	if ($dirId) {
    		$dir->load($dirId);
    	}
    	if ($dirParentId) {
    		$dirParent->load($dirParentId);
    	}
    	if ($dir->getId() && $dirParent->getId() && $dir->getData('dir_company')==$this->_getCompanyId() && $dirParent->getData('dir_company')==$this->_getCompanyId()) {
    		
    		try {
    			$dir->setData('dir_parent',$dirParent->getId());
    			$dir->setData('level_path',($dirParent->getData('level_path') ? $dirParent->getData('level_path').'/'.$dirParent->getId() : $dirParent->getId()));
    			$dir->save();
    		} catch (Exception $e) {
    			$res['succeed'] = false;
    			$res['msg'] = "请求出错，请重试或联系管理员";
    		}
    	} else {
    		$res['succeed'] = false;
    		$res['msg'] = "非法请求，请重试或联系管理员";
    	}
    	echo json_encode($res);
    	
    }
    public function deleteDirAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
    	$dirId = intval($this->getRequest()->getParam('dir_id'));
    	$dir = Mage::getModel('document/dir')->load($dirId);
    	if ($dir->getId()) {
    		if ($dir->getData('dir_create')==Mage::registry('current_user')->getId()) {
    			$ioHandler = new Varien_Io_File();
    			$dirPath = Mage::helper('document')->getCompanyDocumentRoot();
    			try {
    				$ioHandler->rmdirRecursive($dirPath.trim($dir->getData('dir_path')),true);
    				//echo $dirPath.trim($dir->getData('dir_path'));
    				$dir->delete();
    			} catch (Exception $e) {
    				$data['succeed'] = false;
    				
    				$data['msg'] = "请求出错，请重试或联系管理员。";
    			}
    		} else {
    			$data['succeed'] = false;
    			$data['msg'] = "您的权限不足，请确认。";
    		}
    	} else {
    		$data['succeed'] = false;
    		$data['msg'] = "该记录已不存在，请确认。";
    	}
		echo json_encode($res);
    }
    
    
    public function deleteWishAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
    	$dirId = intval($this->getRequest()->getParam('dir_id'));
    	$dir = Mage::getModel('document/dir')->load($dirId);
    	if ($dir->getId()) {
    		$wish = Mage::getResourceModel('document/wish_collection')
	    		->addFieldToFilter('wish_dir',$dirId)
	    		->addFieldToFilter('wish_create',Mage::registry('current_user')->getId())
	    		->setPageSize(1)
	    		->getFirstItem();
	    	if ($wish->getId()) {
	    		//已收藏
				try {
					$wish->delete();
				} catch (Exception $e) {
					$data['succeed'] = false;
					$data['msg'] = "请求出错，请重试或联系管理员。";
				}
	    		
	    	} else {
	    		$wishData = array(
	    			'wish_create' => Mage::registry('current_user')->getId(),
	    			'wish_dir' => $dirId,
	    		);
	    		$wish->addData($wishData);
	    		try {
					$wish->save();
				} catch (Exception $e) {
					$data['succeed'] = false;
					$data['msg'] = "请求出错，请重试或联系管理员。";
				}
	    	}
    	} else {
    		$data['succeed'] = false;
    		$data['msg'] = "该记录已不存在，请确认。";
    		
    	}
		echo json_encode($res);
    }
    
    
    public function addWishAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
    	$dirId = intval($this->getRequest()->getParam('dir_id'));
    	$dir = Mage::getModel('document/dir')->load($dirId);
    	if ($dir->getId()) {
    		$wish = Mage::getResourceModel('document/wish_collection')
	    		->addFieldToFilter('wish_dir',$dirId)
	    		->addFieldToFilter('wish_create',Mage::registry('current_user')->getId())
	    		->setPageSize(1)
	    		->getFirstItem();
	    	if ($wish->getId()) {
	    		//已收藏
				echo $wish->getId();
	    		
	    	} else {
	    		$wishData = array(
	    			'wish_create' => Mage::registry('current_user')->getId(),
	    			'wish_dir' => $dirId,
	    		);
	    		
	    		$wish->addData($wishData);
	    		try {
					$wish->save();
				} catch (Exception $e) {
					$data['succeed'] = false;
					$data['msg'] = "请求出错，请重试或联系管理员。";
				}
	    	}
    	} else {
    		$data['succeed'] = false;
    		$data['msg'] = "该记录已不存在，请确认。";
    		
    	}
		echo json_encode($res);
    }
    
    public function renameSaveAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
    	$dirId = intval($this->getRequest()->getParam('dir_id'));
    	$dirName = trim($this->getRequest()->getParam('dir_name'));
    	$dir = Mage::getModel('document/dir')->load($dirId);
    	if ($dir->getId()) {
    		
	    		
    		$dir->setData('dir_name',$dirName);
    		try {
				$dir->save();
			} catch (Exception $e) {
				$data['succeed'] = false;
				$data['msg'] = "请求出错，请重试或联系管理员。";
			}
	    	
    	} else {
    		$data['succeed'] = false;
    		$data['msg'] = "该记录已不存在，请确认。";
    		
    	}
		echo json_encode($res);
    }
    
    public function getUniqId() {
    	return date('YmdHis').uniqid();
    }
    
}
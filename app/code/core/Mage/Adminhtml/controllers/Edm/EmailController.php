<?php
class Mage_Adminhtml_Edm_EmailController extends Mage_Adminhtml_Controller_Edm
{
	protected function _initCompany() {
		
	}
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('email');
		
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_email', 'email'));
		$this->renderLayout();
	}
	public function listAction() {
		$this->loadLayout();
		$this->_setActiveMenu('email');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_email', 'email'));
		$this->renderLayout();
	}
	public function newAction() {
		$this->_initCompany();
		$this->loadLayout();
		$this->_setActiveMenu('email');
		//echo "<xmp>";var_dump(); echo "</xmp>";
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_email_edit', 'email.edit'));
		$this->renderLayout();
	}
	public function editAction() {
		$this->_initCompany();
		$this->loadLayout();
		$this->_setActiveMenu('email');
		
		
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_email_edit', 'email.edit'));
		$this->renderLayout();
	}
	public function saveAction() {
		$data = $this->getRequest()->getParams();
		$cha = Mage::getModel('plan/character');
		if (isset($data['id']) && $data['id']) {
			$cha->load($data['id']);
		}
		unset($data['id']);
        //echo "<xmp>";var_dump($data);die();     
		
		//保存图片
		//var_dump($_FILES);die();
        if(isset($_FILES['email_url']['name']) and (file_exists($_FILES['email_url']['tmp_name']))) {  
        	
		    try {  
			    $uploader = new Mage_Core_Model_File_Uploader('email_url');
	            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
	            $uploader->setAllowRenameFiles(true);
	            //$uploader->setFilesDispersion(true); //分目录
	            $ext = explode('.',$_FILES['email_url']['name']);
	            list($usec, $sec) = explode(" ", microtime());
	            $usec = (int)$usec*10000;
	            $chaNamePre = date('YmdHis').$usec.rand(1000,9999);
	            $chaName = str_replace('.','',$chaNamePre).'.'.$ext[count($ext)-1];
	            
	            $result = $uploader->save($this->getTmpFilePath(),$chaName);
				//删除旧文件???
	            $url = $this->getFileUrl($chaName);
			    $data['email_url'] = $url;  
		    }catch(Exception $e) {  
		      unset($data['email_url']);
		    }  
	    } else {  
  
		    if(isset($data['email_url']['delete']) && $data['email_url']['delete'] == 1) {
		    	$data['email_url'] = '';  
		    } else {
		    	unset($data['email_url']);
		    }
        }
		
		$cha->addData($data);
		try {
			$cha->save();
			$this->_getSession()->addSuccess('开发信保存成功');
		} catch (Exception $e) {
			
			Mage::log('开发信保存失败:#'.$cha->getId(),false,'plan.log');
			$this->_getSession()->addError($e->getMessage());
		}
		if ($this->getRequest()->getParam('back')) {
    		$this->_redirect('*/*/edit',array('id'=>$cha->getId()));
    	} else {
    		$this->_redirect('*/*/index');
    	}

	}
	
    public function deleteAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$cha = Mage::getModel('plan/character')->load($id);
    
    	try {
    		 $cha->delete();
    		 $this->_getSession()->addSuccess("删除成功");
    	} catch(Exception $e) {
    		$this->_getSession()->addError();
    	}
    	$this->_redirect('*/*/index');
    }
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('email');
    }
}

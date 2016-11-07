<?php
/***
 * 系统设置 - 企业信息设置
 */
class Mage_Adminhtml_Setting_CompanyController extends Mage_Adminhtml_Controller_Setting
{
    public function indexAction()
    {
        $this->_title($this->__('企业信息设置'));
        $this->loadLayout();
        $this->_setActiveMenu('setting/company');
        $this->_addContent($this->getLayout()->createBlock('adminhtml/setting_company_edit', 'setting.company'));
        $this->renderLayout();
    }
    
    
    /*
     * 保存企业信息
     */
    public function saveAction() {
		$data = $this->getRequest()->getParams();
		$company = Mage::getModel('admin/company');
		if (isset($data['id']) && $data['id']) {
			$company->load($data['id']);
		}
		unset($data['id']);
		
		//公司LOGO
		if(isset($_FILES['company_logo']['name']) and (file_exists($_FILES['company_logo']['tmp_name']))) {  
        	
		    try {  
			    $uploader = new Mage_Core_Model_File_Uploader('company_logo');
	            $uploader->setAllowedExtensions(array('jpg','jpeg','png'));
	            $uploader->setAllowRenameFiles(true);
	            //$uploader->setFilesDispersion(true); //分目录
	            $ext = explode('.',$_FILES['company_logo']['name']);
	            list($usec, $sec) = explode(" ", microtime());
	            $usec = (int)$usec*10000;
	            $logoNamePre = date('YmdHis').$usec.rand(1000,9999);
	            $logoName = str_replace('.','',$logoNamePre).'.'.$ext[count($ext)-1];
	            
	            $result = $uploader->save($this->getTmpFilePath(),$logoName);
				//删除旧文件???
	            $url = $this->getFileUrl($logoName);
			    $data['company_logo'] = $url;  
		    } catch(Exception $e) {  
		    	$this->_getSession()->addError($e->getMessage());
		    	$this->_getSession()->addError("企业Logo上传失败，请联系管理员");
		    	$this->_redirect('*/*/index');
		    	return;
		        
		    }  
	    } else {  
  
		    if(isset($data['company_logo']['delete']) && $data['company_logo']['delete'] == 1) {
		    	$data['company_logo'] = '';  
		    } else {
		    	unset($data['company_logo']);
		    }
        }
		$company->addData($data);
		try {
			$company->save();
			$this->_getSession()->addSuccess('企业信息保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("企业信息保存失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}
	
	public function getTmpFilePath()
    {
        return Mage::getBaseDir('media'). DS . 'company' . DS . 'logo' .DS;
    }
    public function getFileUrl($path) {
    	return 'company/logo/'.str_replace(DS,'/',$path);
    }
}
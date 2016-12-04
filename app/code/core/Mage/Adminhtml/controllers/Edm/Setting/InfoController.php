<?php
/***
 * 应用设置 基本信息设置
 */
class Mage_Adminhtml_Edm_Setting_InfoController extends Mage_Adminhtml_Controller_Edm {
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('setting/info');
		$this->_title("应用设置")->_title("基本信息");
		
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_setting_info', 'info'));
		$this->renderLayout();
	}
	
	public function saveAction() {
		$data = $this->getRequest()->getParams();
		$edmCompany = Mage::registry('current_edm_company');
		if ($edmCompany->getId()) {
			if ($edmCompany->getData('company_id')!=$this->_getCompanyId()) {
				$this->_getSession()->addError('非法操作！');
				$this->_redirect('*/*/index');
				return;
			}
		} else {
			$data['company_id'] = $this->_getCompanyId();
		}
		
		//公司LOGO
		if(isset($_FILES['company_logo']['name']) and (file_exists($_FILES['company_logo']['tmp_name']))) {  
        	
		    try {  
			    $uploader = new Mage_Core_Model_File_Uploader('company_logo');
	            $uploader->setAllowedExtensions(array('jpg','jpeg','png','gif'));
	            $uploader->setAllowRenameFiles(true);
	            $ext = explode('.',$_FILES['company_logo']['name']);
	           
	            $logoName = 'logo_email.'.$ext[count($ext)-1];
	            $result = $uploader->save($this->getTmpFilePath(),$logoName);
	            $url = $this->getFileUrl($logoName);
	            //var_dump($url);die();
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
        $edmCompany->addData($data);
		try {
			$edmCompany->save();
			$this->_getSession()->addSuccess('信息保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError('对不起，保存失败，请稍后重试或联系管理员');
		}
		$this->_redirect('*/*/index');
	}
	
	
	public function catAction() {
		$this->loadLayout();
		$this->_setActiveMenu('setting/cat');
		$this->_title("帐号设置")->_title("基本信息");
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_setting_cat', 'info.cat'));
		$this->renderLayout();
	}
    
    	public function getsubcatAction() {
		$catIds = explode(',',trim($this->getRequest()->getParam('ids')));
		$res = array('ret'=>-1,'msg'=>'');
		if (count($catIds)) {
			Mage::register('current_cateogries',$catIds);
			$res['ret'] = 1;
			$res['data'] = $output = Mage::getBlockSingleton('adminhtml/template')
				->setTemplate('edm/setting/subcat.phtml')->toHtml();;
		}
		
		
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));
	}
	
	public function savecatAction() {
		$catIds = explode(',',trim($this->getRequest()->getParam('ids')));
		$res = array('ret'=>-1,'msg'=>'');
		$company = Mage::registry('current_company');
		//保存产品分类
		$cats = Mage::getResourceModel('edm/company_category_collection')
				->addFieldToFilter('company_id',$company->getId());
		
		$catOldIds = array();
		$catOldIdsTmp = array();
		foreach ($cats as $_cat) {
			array_push($catOldIds,$_cat->getCategoryId());
			$catOldIdsTmp[$_cat->getCategoryId()] = $_cat->getId();
		}
		//var_dump($catOldIds);
		foreach ($catOldIds as $_id) {
			if (!in_array($_id,$catIds)) {
				//删除
				Mage::getModel('edm/company_category')->load($catOldIdsTmp[$_id])->delete();
			}
		}
		foreach ($catIds as $_id) {
			if (!in_array($_id,$catOldIds)) {
				//添加
				$cats = Mage::getModel('edm/company_category')
					->setData('company_id',$company->getId())
					->setData('category_id',$_id)
					->save();
			}
		}
		
		$res['ret'] = 1;
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));
	}
	public function _isAllowed() {
    	return true;
	}
	
	public function getTmpFilePath()
    {
        return Mage::helper('edm/media')->getPathPrefix(). 'logo' .DS;
    }
    public function getFileUrl($path) {
    	return Mage::helper('edm/media')->getUrlPrefix() . 'logo/'.str_replace(DS,'/',$path);
    }
}
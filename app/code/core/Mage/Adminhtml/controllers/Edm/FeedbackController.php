<?php
class Mage_Adminhtml_Edm_FeedbackController extends Mage_Adminhtml_Controller_Edm
{
    public function indexAction()
    {
    	
        $this->_title($this->__('反馈信息'));
        $this->loadLayout();
        $this->_setActiveMenu('feedback/index');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_feedback', 'feedback'));
        $this->renderLayout();
    }
    public function viewAction() {
    	$id = (int)$this->getRequest()->getParam('id');
    	$feedback = Mage::getModel('edm/feedback')->load($id);
    	
    	Mage::register('current_feedback',$feedback);
    	if ($feedback->getId()) {
    		 $this->_title($this->__('查看反馈详情'));
	        $this->loadLayout();
	        $this->_setActiveMenu('feedback/index');
	        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_feedback_view', 'feedback.view'));
	        $this->renderLayout();
    	} else {
    		$this->_getSession()->addError('反馈记录已不存在，请重试。');
			$this->_redirect('*/*');
    	}
    }
    public function newAction() {
    	$this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('反馈信息'));
        $this->loadLayout();
        $id = $this->getRequest()->getParam('id',0);
        $feedback = Mage::getModel('edm/feedback');
        if ($id) {
        	$feedback->load($id);
        	if ($feedback->getId() && $feedback->getData('feedback_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError('非法操作！');
				$this->_redirect('*/*/index');
				return;
			}
        }
        Mage::register('current_feedback',$feedback);
        $this->_setActiveMenu('feedback/new');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_feedback_edit', 'feedback.edit'));
        $this->renderLayout();
    }
	public function myAction()
    {
    	
        $this->_title($this->__(' 提交历史 - 反馈信息'));
        $this->loadLayout();
        $this->_setActiveMenu('feedback/my');
        Mage::register('current_filter','my');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_feedback', 'feedback'));
        $this->renderLayout();
    }
    public function saveAction() {
		$data = $this->getRequest()->getParams();
		$feedback = Mage::getModel('edm/feedback');
		if (isset($data['id']) && $data['id']) {
			$feedback->load($data['id']);
		}
		unset($data['id']);
        //echo "<xmp>";var_dump($data);die();     
		$data['feedback_company'] = Mage::registry('current_company')->getId();
		//保存图片
        if(isset($_FILES['feedback_image']['name']) and (file_exists($_FILES['feedback_image']['tmp_name']))) {  
		    try {  
			    $uploader = new Mage_Core_Model_File_Uploader('feedback_image');
	            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
	            $ext = explode('.',$_FILES['feedback_image']['name']);
	            list($usec, $sec) = explode(" ", microtime());
	            $usec = (int)$usec*10000;
	            $feedbackNamePre = date('YmdHis').$usec.rand(1000,9999);
	            $feedbackName = str_replace('.','',$feedbackNamePre).'.'.$ext[count($ext)-1];
	            $result = $uploader->save($this->getTmpFilePath(),$feedbackName);
	            $url = $this->getFileUrl($feedbackName);
			    $data['feedback_image'] = $url;  
		    }catch(Exception $e) {  
		      unset($data['feedback_image']);
		    }  
	    } else {
		    if(isset($data['feedback_image']['delete']) && $data['feedback_image']['delete'] == 1) {
		    	$data['feedback_image'] = '';  
		    } else {
		    	unset($data['feedback_image']);
		    }
        }
        
        
        
        if(isset($_FILES['feedback_image2']['name']) and (file_exists($_FILES['feedback_image2']['tmp_name']))) {  
		    try {  
			    $uploader = new Mage_Core_Model_File_Uploader('feedback_image2');
	            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
	            $ext = explode('.',$_FILES['feedback_image2']['name']);
	            list($usec, $sec) = explode(" ", microtime());
	            $usec = (int)$usec*10000;
	            $feedbackNamePre = date('YmdHis').$usec.rand(1000,9999);
	            $feedbackName = str_replace('.','',$feedbackNamePre).'.'.$ext[count($ext)-1];
	            $result = $uploader->save($this->getTmpFilePath(),$feedbackName);
	            $url = $this->getFileUrl($feedbackName);
			    $data['feedback_image2'] = $url;  
		    }catch(Exception $e) {  
		      unset($data['feedback_image2']);
		    }  
	    } else {
		    if(isset($data['feedback_image2']['delete']) && $data['feedback_image2']['delete'] == 1) {
		    	$data['feedback_image2'] = '';  
		    } else {
		    	unset($data['feedback_image2']);
		    }
        }
        
        if(isset($_FILES['feedback_image3']['name']) and (file_exists($_FILES['feedback_image3']['tmp_name']))) {  
		    try {  
			    $uploader = new Mage_Core_Model_File_Uploader('feedback_image3');
	            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
	            $ext = explode('.',$_FILES['feedback_image3']['name']);
	            list($usec, $sec) = explode(" ", microtime());
	            $usec = (int)$usec*10000;
	            $feedbackNamePre = date('YmdHis').$usec.rand(1000,9999);
	            $feedbackName = str_replace('.','',$feedbackNamePre).'.'.$ext[count($ext)-1];
	            $result = $uploader->save($this->getTmpFilePath(),$feedbackName);
	            $url = $this->getFileUrl($feedbackName);
			    $data['feedback_image3'] = $url;  
		    }catch(Exception $e) {  
		      unset($data['feedback_image3']);
		    }  
	    } else {
		    if(isset($data['feedback_image3']['delete']) && $data['feedback_image3']['delete'] == 1) {
		    	$data['feedback_image3'] = '';  
		    } else {
		    	unset($data['feedback_image3']);
		    }
        }
		
		$feedback->addData($data);
		try {
			$feedback->save();
			$this->_getSession()->addSuccess('反馈信息提交成功');
		} catch (Exception $e) {
			
			Mage::log('馈信息提交失败:#'.$feedback->getId(),false,'plan.log');
			$this->_getSession()->addError("馈信息提交失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}
    protected function _isAllowed()
    {
    	return true;
        //return Mage::getSingleton('admin/session')->isAllowed('dashboard');
    }
    
    public function getTmpFilePath()
    {
        return Mage::helper('edm/media')->getPathPrefix(). 'feedback' .DS;
    }
    public function getFileUrl($path) {
    	return Mage::helper('edm/media')->getUrlPrefix() . 'feedback/'.str_replace(DS,'/',$path);
    }
}

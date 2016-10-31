<?php
class Mage_Adminhtml_Edm_FeedbackController extends Mage_Adminhtml_Controller_Edm
{
    public function indexAction()
    {
    	
        $this->_title($this->__('反馈信息'));
        $this->loadLayout();
        $this->_setActiveMenu('feedback');
        $this->renderLayout();
    }
    public function newAction() {
    	$this->_forward('index');
    }
	public function myAction()
    {
    	
        $this->_title($this->__(' 提交历史 - 反馈信息'));
        $this->loadLayout();
        $this->_setActiveMenu('feedback');
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
		//var_dump($_FILES);die();
        if(isset($_FILES['image']['name']) and (file_exists($_FILES['image']['tmp_name']))) {  
        	
		    try {  
			    $uploader = new Mage_Core_Model_File_Uploader('image');
	            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
	            $uploader->setAllowRenameFiles(true);
	            //$uploader->setFilesDispersion(true); //分目录
	            $ext = explode('.',$_FILES['image']['name']);
	            list($usec, $sec) = explode(" ", microtime());
	            $usec = (int)$usec*10000;
	            $feedbackNamePre = date('YmdHis').$usec.rand(1000,9999);
	            $feedbackName = str_replace('.','',$feedbackNamePre).'.'.$ext[count($ext)-1];
	            
	            $result = $uploader->save($this->getTmpFilePath(),$feedbackName);
				//删除旧文件???
	            $url = $this->getFileUrl($feedbackName);
			    $data['image'] = $url;  
		    }catch(Exception $e) {  
		      unset($data['image']);
		    }  
	    } else {  
  
		    if(isset($data['image']['delete']) && $data['image']['delete'] == 1) {
		    	$data['image'] = '';  
		    } else {
		    	unset($data['image']);
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
        //return Mage::helper('plan')->getBaseMediaDir(). DS . 'plan' . DS . 'product' .DS .'a' .DS;
        return Mage::getBaseDir('media'). DS . 'feedback' .DS;
    }
    public function getFileUrl($path) {
    	return 'feedback/'.str_replace(DS,'/',$path);
    }
}

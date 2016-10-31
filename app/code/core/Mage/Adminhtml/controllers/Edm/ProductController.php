<?php
class Mage_Adminhtml_Edm_ProductController extends Mage_Adminhtml_Controller_Edm
{

	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('account');
		
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_product', 'product'));
		$this->renderLayout();
	}
	public function listAction() {
		$this->loadLayout();
		$this->_setActiveMenu('account');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_product', 'product'));
		$this->renderLayout();
	}
	public function newAction() {

		$this->loadLayout();
		$this->_setActiveMenu('account');
		$product = Mage::getModel('edm/product');
		Mage::register('current_product',$product);
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_product_edit', 'product.edit'));
		$this->renderLayout();
	}
	public function editAction() {
		$id = $this->getRequest()->getParam('id',false);

		$this->loadLayout();
		$this->_setActiveMenu('account');
		$product = Mage::getModel('edm/product');
		if ($id) {
			$product->load($id);
		}
		Mage::register('current_product',$product);
		
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_product_edit', 'product.edit'));
		$this->renderLayout();
	}
	public function saveAction() {
		$data = $this->getRequest()->getParams();
		$product = Mage::getModel('edm/product');
		if (isset($data['id']) && $data['id']) {
			$product->load($data['id']);
			if ($product->getData('company_id')!=Mage::registry('current_company')->getId()) {
				$this->_getSession()->addError("非法操作");
				$this->_redirect('*/*/index');
			}
		} else {
			$data['company_id'] = age::registry('current_company')->getId();
		}
		unset($data['id']);

        if(isset($_FILES['image']['name']) and (file_exists($_FILES['image']['tmp_name']))) {  
        	
		    try {  
			    $uploader = new Mage_Core_Model_File_Uploader('image');
	            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
	            $uploader->setAllowRenameFiles(true);
	            //$uploader->setFilesDispersion(true); //分目录
	            $ext = explode('.',$_FILES['image']['name']);
	            list($usec, $sec) = explode(" ", microtime());
	            $usec = (int)$usec*10000;
	            $productNamePre = date('YmdHis').$usec.rand(1000,9999);
	            $productName = str_replace('.','',$productNamePre).'.'.$ext[count($ext)-1];
	            
	            $result = $uploader->save($this->getTmpFilePath(),$productName);
				//删除旧文件???
	            $url = $this->getFileUrl($productName);
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
		
		$product->addData($data);
		try {
			$product->save();
			$this->_getSession()->addSuccess('产品保存成功');
		} catch (Exception $e) {
			
			Mage::log('产品保存失败:#'.$product->getId(),false,'plan.log');
			$this->_getSession()->addError($e->getMessage());
		}
		if ($this->getRequest()->getParam('back')) {
    		$this->_redirect('*/*/edit',array('id'=>$product->getId()));
    	} else {
    		$this->_redirect('*/*/index');
    	}

	}
	
    public function deleteAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$product = Mage::getModel('edm/product')->load($id);
    
    	try {
    		 $product->delete();
    		 $this->_getSession()->addSuccess("删除成功");
    	} catch(Exception $e) {
    		$this->_getSession()->addError();
    	}
    	$this->_redirect('*/*/index');
    }
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('product');
    }
    
	public function getTmpFilePath()
    {
        //return Mage::helper('plan')->getBaseMediaDir(). DS . 'plan' . DS . 'product' .DS .'a' .DS;
        return Mage::getBaseDir('media'). DS . 'wysiwyg' . DS . 'product' .DS;
    }
    public function getFileUrl($path) {
    	return 'media/wysiwyg/product/'.str_replace(DS,'/',$path);
    }
}

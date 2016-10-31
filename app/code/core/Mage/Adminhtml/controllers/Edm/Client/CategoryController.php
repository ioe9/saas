<?php
class Mage_Adminhtml_Edm_Client_CategoryController extends Mage_Adminhtml_Controller_Edm {
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('ins_product');
		$this->_title("客户分组管理")->_title("客户分组设置");
		
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_company_client_category', 'product'));
		$this->renderLayout();
	}
	public function listAction() {
		$this->_forward('index');
	}
	public function newAction() {
		$this->_forward('edit');
	}
	public function editAction() {
		$id = $this->getRequest()->getParam('id');
		$category = Mage::getModel('edm/company_client_cateogry')->load($id);
		
		$this->loadLayout();
		
		$this->_setActiveMenu('ins_product');
		Mage::register('current_category',$category);
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_company_client_category_edit', 'product'));
       
		$this->renderLayout();
	}
	public function saveAction() {
		$data = $this->getRequest()->getParams();
		$category = Mage::getModel('edm/company_client_cateogry');
		if (isset($data['id']) && $data['id']) {
			$category->load($data['id']);
		}
		unset($data['id']);
        if ($data['parent_id']) {
        	$parent = Mage::getModel('edm/company_client_cateogry')->load($data['parent_id']);
        	$data['level'] = $parent->getLevel()+1;
        }

		$category->addData($data);
		try {
			$category->save();
			
			$this->_getSession()->addSuccess('分组保存成功');
		} catch (Exception $e) {
			
			Mage::log('分组保存失败:#'.$category->getId(),false,'ins.log');
			$this->_getSession()->addError($e->getMessage());
		}
		if ($this->getRequest()->getParam('back')) {
    		$this->_redirect('*/*/edit',array('id'=>$category->getId()));
    	} else {
    		$this->_redirect('*/*/index');
    	}

	}
	public function clientgridAction() {
       	$id = (int) $this->getRequest()->getParam('id');
		$model = Mage::getModel('edm/company_client_cateogry');
        if ($id) {
            $model->load($id);
        }
        Mage::register('current_category', $model);
		$this->getResponse()->setBody($this->getLayout()
		  ->createBlock('edm/adminhtml_company_client_category_edit_tab_client','productGrid')->toHtml());
	}
    public function deleteAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$category = Mage::getModel('edm/company_client_category')->load($id);
    
    	try {
    		 $category->delete();
    		 $this->_getSession()->addSuccess("分组删除成功");
    	} catch(Exception $e) {
    		$this->_getSession()->addError();
    	}
    	$this->_redirect('*/*/index');
    }
	public function _isAllowed() {
    	return true;
	}
}
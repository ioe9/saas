<?php
/***
 * 
 */
class Mage_Adminhtml_ExpressController extends Mage_Adminhtml_Controller_Express
{
    public function indexAction()
    {
        $this->_title($this->__("快递单"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->_addContent($this->getLayout()->createBlock('express/adminhtml_express', 'express'));
        $this->renderLayout();
    }
	public function newAction() {
		$this->_forward('edit');
	}
	public function editAction() {
		$id = $this->getRequest()->getParam('id',false);
		
		$this->loadLayout();
		$this->_setActiveMenu('index');
		$express = Mage::getModel('express/express');
		if ($id) {
			$express->load($id);
		}
		if ($express->getId()) {
			$this->_title($this->__("编辑快递单：".$express->getData('express_code')));
		} else {
			$this->_title($this->__("新增快递单"));
		}
		Mage::register('current_express',$express);
		
        $this->_addContent($this->getLayout()->createBlock('express/adminhtml_express_edit', 'express.edit'));
		$this->renderLayout();
	}
	
	
	public function saveAction() {
		$data = $this->getRequest()->getParams();
		$express = Mage::getModel('express/express');
		if (isset($data['id']) && $data['id']) {
			$express->load($data['id']);
			if ($express->getData('express_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		}
		unset($data['id']);
        //echo "<xmp>";var_dump($data);die();     
		$data['express_company'] = Mage::registry('current_company')->getId();
		$express->addData($data);
		try {
			$express->save();
			$this->_getSession()->addSuccess('快件保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("快件保存失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}
}

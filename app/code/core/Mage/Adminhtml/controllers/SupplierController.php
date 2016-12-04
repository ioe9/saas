<?php
/***
 * 
 */
class Mage_Adminhtml_SupplierController extends Mage_Adminhtml_Controller_Supplier
{
    public function indexAction()
    {
        $this->_title($this->__("供应商"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->_addContent($this->getLayout()->createBlock('supplier/adminhtml_supplier', 'supplier'));
        $this->renderLayout();
    }
	
	public function newAction() {
		$this->_forward('edit');
	}
	public function editAction() {
		$id = $this->getRequest()->getParam('id',false);
		
		$this->loadLayout();
		$this->_setActiveMenu('index');
		$supplier = Mage::getModel('supplier/supplier');
		if ($id) {
			$supplier->load($id);
		}
		if ($supplier->getId()) {
			$this->_title($this->__("编辑供应商：".$supplier->getData('supplier_sku')));
		} else {
			$this->_title($this->__("新增供应商"));
		}
		Mage::register('current_supplier',$supplier);
		
        $this->_addContent($this->getLayout()->createBlock('supplier/adminhtml_supplier_edit', 'supplier.edit'));
		$this->renderLayout();
	}
	
	
	public function saveAction() {
		$data = $this->getRequest()->getParams();
		$supplier = Mage::getModel('supplier/supplier');
		if (isset($data['id']) && $data['id']) {
			$supplier->load($data['id']);
			if ($supplier->getData('supplier_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		}
		unset($data['id']);
        //echo "<xmp>";var_dump($data);die();     
		$data['supplier_company'] = Mage::registry('current_company')->getId();
		$supplier->addData($data);
		try {
			$supplier->save();
			$this->_getSession()->addSuccess('供应商保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("供应商保存失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}

}

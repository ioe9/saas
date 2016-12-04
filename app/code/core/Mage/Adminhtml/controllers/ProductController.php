<?php
/***
 * 
 */
class Mage_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Product
{
    public function indexAction()
    {
        $this->_title($this->__("产品"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->_addContent($this->getLayout()->createBlock('product/adminhtml_product', 'product'));
        $this->renderLayout();
    }
	
	public function newAction() {
		$this->_forward('edit');
	}
	public function editAction() {
		$id = $this->getRequest()->getParam('id',false);
		
		$this->loadLayout();
		$this->_setActiveMenu('index');
		$product = Mage::getModel('product/product');
		if ($id) {
			$product->load($id);
		}
		if ($product->getId()) {
			$this->_title($this->__("编辑产品：".$product->getData('product_sku')));
		} else {
			$this->_title($this->__("新增产品"));
		}
		Mage::register('current_product',$product);
		
        $this->_addContent($this->getLayout()->createBlock('product/adminhtml_product_edit', 'product.edit'));
		$this->renderLayout();
	}
	
	
	public function saveAction() {
		$data = $this->getRequest()->getParams();
		$product = Mage::getModel('product/product');
		if (isset($data['id']) && $data['id']) {
			$product->load($data['id']);
			if ($product->getData('product_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		}
		unset($data['id']);
        //echo "<xmp>";var_dump($data);die();     
		$data['product_company'] = Mage::registry('current_company')->getId();
		$product->addData($data);
		try {
			$product->save();
			$this->_getSession()->addSuccess('产品保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("产品保存失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}
}

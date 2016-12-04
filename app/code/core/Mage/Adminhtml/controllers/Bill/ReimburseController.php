<?php
/***
 * 报销管理
 */
class Mage_Adminhtml_Bill_ReimburseController extends Mage_Adminhtml_Controller_Bill
{
	/****
	 * 我的报销
	 */
    public function myAction()
    {
        $this->_title($this->__('报销管理'));
        $this->loadLayout();
        $this->_setActiveMenu('bill/my');
        $this->_addContent($this->getLayout()->createBlock('bill/adminhtml_reimburse', 'reimburse'));
        $this->renderLayout();
    }
	

    public function newAction()
    {
    	$this->_title($this->__('新建报销'));
        $this->loadLayout();
        $this->_setActiveMenu('bill/new');
        $this->_addContent($this->getLayout()->createBlock('bill/adminhtml_reimburse_new', 'reimburse.process'));
        $this->renderLayout();
    }
    
    public function editAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$reimburse = Mage::getModel('bill/reimburse')->load($id);
    	
    	if ($reimburse->getId()) {
    		//判断归属
    		if ($reimburse->getData('rei_create')!=$this->_getUser()->getId()) {
    			$this->_getSession()->addError('非法操作！');
    			$this->_redirect('*/*');
    		}
    	}
    	Mage::register('current_reimburse',$reimburse);
        
        $this->loadLayout();
        if ($reimburse->getId()) {
        	$this->_title($this->__('编辑报销'));
        } else {
        	$this->_title($this->__('新建报销'));
        }
        $this->_setActiveMenu('bill/submit');
        $this->_addContent($this->getLayout()->createBlock('bill/adminhtml_reimburse_edit_form', 'reimburse.edit'));
        $this->renderLayout();
    }
    
    /*
     * 保存报销管理
     */
    public function saveAction() {
		$data = $this->getRequest()->getParams();
		$reimburse = Mage::getModel('bill/reimburse');
		$isNew = false;
		if (isset($data['id']) && $data['id']) {
			$reimburse->load($data['id']);
			if ($reimburse->getData('rei_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		} else {
			$isNew = true;
		}
		unset($data['id']);
        //echo "<xmp>";var_dump($data);die();     
		$data['rei_company'] = Mage::registry('current_company')->getId();
		$data['rei_create'] = $this->_getUser()->getId();
		$reimburse->addData($data);
		try {
			$reimburse->save();
			$this->_getSession()->addSuccess('报销生成成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("报销保存失败，请重试或联系管理员");
		}
		if ($isNew) {
			$this->_redirect('adminhtml/bill_reimburse/edit',array('id'=>$reimburse->getId()));
		} else {
			
		}
		
		
	}
    /*
     * 保存报销明细
     */
    public function saveItemAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
		);
		$reiId = $this->getRequest()->getParam('rei_id');
		$itemType = $this->getRequest()->getParam('item_type');
		$itemMemo = $this->getRequest()->getParam('item_memo');
		$totalRei = $this->getRequest()->getParam('total_rei');
		$reimburse = Mage::getModel('bill/reimburse');
		$item = Mage::getModel('bill/reimburse_item');
		$isNew = false;
		if ($reiId) { 
			$reimburse->load($reiId);
			if ($reimburse->getData('rei_company')!=$this->_getCompanyId()) {
				$res['succeed'] = false;
				$res['msg'] = "非法操作，您的IP已被我们记录！";
			}
			$data = array();
			$data['item_rei'] = $reiId;
			$data['item_type'] = $itemType;
			$data['item_memo'] = $itemMemo;
			$data['total_rei'] = $totalRei;
			$item->addData($data);
			try {
				$item->save();
				$res['succeed'] = true;
			} catch (Exception $e) {
				$res['succeed'] = false;
				$res['msg'] = "报销保存失败，请重试或联系管理员";
			}
		} else {
			$res['succeed'] = false;
			$res['msg'] = "无效操作，请重试。";
		}
			
		echo json_encode($res);
		
	} 
    public function viewAction() {
    	$id = (int)$this->getRequest()->getParam('id');
    	$reimburse = Mage::getModel('bill/bill')->load($id);
    	$back = $this->getRequest()->getParam('back');
    	$back = $back ? $back : 'submit';
    	Mage::register('current_reimburse',$reimburse);
    	if ($reimburse->getId()) {
    		 $this->_title($this->__('查看报销'));
	        $this->loadLayout();
	        $this->_setActiveMenu('bill/'.$back);
	        $this->_addContent($this->getLayout()->createBlock('bill/adminhtml_reimburse_view', 'reimburse.view'));
	        $this->renderLayout();
    	} else {
    		$this->_getSession()->addError('报销记录已不存在，请重试。');
			$this->_redirect('*/*');
    	}
    }
    
    /****************** audit *******************/
    /*
     * 保存审核信息
     */
    public function saveAuditAction() {
		$data = $this->getRequest()->getParams();
		$reimburse = Mage::getModel('bill/reimburse');
		$audit = Mage::getModel('bill/reimburse_audit');
		if (isset($data['audit_rei']) && $data['audit_rei']) {
			$reimburse->load($data['audit_rei']);
			if ($reimburse->getData('rei_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		}
		$data['audit_create'] = Mage::registry('current_user')->getId();
		$audit->addData($data);
		try {
			$audit->save();
			$this->_getSession()->addSuccess('审核提交成功');
		} catch (Exception $e) {
			echo $e->getMessage();die();
			$this->_getSession()->addError("审核保存失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}


}
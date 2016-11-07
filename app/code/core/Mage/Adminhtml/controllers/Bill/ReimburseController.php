<?php
/***
 * 报销管理
 */
class Mage_Adminhtml_Bill_ReimburseController extends Mage_Adminhtml_Controller_Report
{
	/****
	 * 我的报销
	 */
    public function indexAction()
    {
        $this->_title($this->__('报销管理'));
        $this->loadLayout();
        $this->_setActiveMenu('bill/my');
        $this->_addContent($this->getLayout()->createBlock('bill/adminhtml_bill_reimburse', 'reimburse'));
        $this->renderLayout();
    }
	
    /*
     * 保存报销管理
     */
    public function saveAction() {
		$data = $this->getRequest()->getParams();
		$bill = Mage::getModel('bill/bill');
		if (isset($data['id']) && $data['id']) {
			$bill->load($data['id']);
			if ($bill->getData('bill_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		}
		unset($data['id']);
        //echo "<xmp>";var_dump($data);die();     
		$data['bill_company'] = Mage::registry('current_company')->getId();
		$bill->addData($data);
		try {
			$bill->save();
			$chargeOldArr = explode(',',$data['bill_charge_old']);
			$chargeArr = explode(',',$data['bill_charge']);
			$ccOldArr = explode(',',$data['bill_cc_old']);
			$ccArr = explode(',',$data['bill_cc']);
			
			$delChargeArr = array_diff($chargeOldArr,$chargeArr);
			$addChargeArr = array_diff($chargeArr,$chargeOldArr);
			
			$delCcArr = array_diff($ccOldArr,$ccArr);
			$addCcArr = array_diff($ccArr,$ccOldArr);
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');    
			
			$billId = $bill->getId();
			$chargeType = Mage_Report_Model_Link::LINK_TYPE_TO;
			$chargeCc = Mage_Report_Model_Link::LINK_TYPE_CC;
			foreach ($delChargeArr as $v) {
				$v = (int)$v;
				$write->query("delete from bill_link where link_bill='$billId' and link_type='$chargeType' and link_user='$v'");  
			}
			foreach ($addChargeArr as $v) {
				$v = (int)$v;
				$write->query("insert into bill_link(link_bill,link_type,link_user) values('$billId','$chargeType','$v')");  
			}
			
			foreach ($delCcArr as $v) {
				$v = (int)$v;
				$write->query("delete from bill_link where link_bill='$billId' and link_type='$chargeCc' and link_user='$v'");  
			}
			foreach ($addCcArr as $v) {
				$v = (int)$v;
				$write->query("insert into bill_link(link_bill,link_type,link_user) values('$billId','$chargeCc','$v')");  
			}
			
			$this->_getSession()->addSuccess('报销管理保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("报销管理保存失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}
    public function newAction()
    {
        $this->_forward('edit');
    }
    
    public function editAction()
    {
    	$id = (int)$this->getRequest()->getParam('id');
    	$bill = Mage::getModel('bill/reimburse')->load($id);
    	
    	if ($bill->getId()) {
    		//判断归属
    		if ($bill->getData('bill_create')!=$this->_getUser()->getId()) {
    			$this->_getSession()->addError('非法操作！');
    			$this->_redirect('*/*');
    		}
    	}
    	Mage::register('current_bill',$bill);
        
        $this->loadLayout();
        if ($bill->getId()) {
        	$this->_title($this->__('编辑报销'));
        } else {
        	$this->_title($this->__('新建报销'));
        }
        $this->_setActiveMenu('bill/submit');
        $this->_addContent($this->getLayout()->createBlock('bill/adminhtml_reimburse_edit', 'reimburse.edit'));
        $this->renderLayout();
    }
    
    public function viewAction() {
    	$id = (int)$this->getRequest()->getParam('id');
    	$bill = Mage::getModel('bill/bill')->load($id);
    	$back = $this->getRequest()->getParam('back');
    	$back = $back ? $back : 'submit';
    	Mage::register('current_bill',$bill);
    	if ($bill->getId()) {
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
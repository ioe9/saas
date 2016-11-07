<?php
/***
 * 工作报告 首页
 */
class Mage_Adminhtml_ReportController extends Mage_Adminhtml_Controller_Report
{
    public function indexAction()
    {
        $this->_title($this->__('工作报告'));
        $this->loadLayout();
        $this->_setActiveMenu('report/index');
        $this->_addContent($this->getLayout()->createBlock('report/adminhtml_dashboard', 'dashboard'));
        $this->renderLayout();
    }
	
	public function submittoAction()
    {
        $this->_title($this->__('提交给我的'));
        $this->loadLayout();
        Mage::register('current_filter','submitto');
        $this->_setActiveMenu('report/submitto');
        $this->_addContent($this->getLayout()->createBlock('report/adminhtml_report', 'report'));
        $this->renderLayout();
    }
	public function cctoAction()
    {
        $this->_title($this->__('抄送给我的'));
        $this->loadLayout();
        Mage::register('current_filter','ccto');
        $this->_setActiveMenu('report/ccto');
        $this->_addContent($this->getLayout()->createBlock('report/adminhtml_report', 'report'));
        $this->renderLayout();
    }
    public function submitAction()
    {
        $this->_title($this->__('我提交的'));
        $this->loadLayout();
        Mage::register('current_filter','submit');
        $this->_setActiveMenu('report/submit');
        $this->_addContent($this->getLayout()->createBlock('report/adminhtml_report', 'report'));
        $this->renderLayout();
    }
    /*
     * 保存工作报告
     */
    public function saveAction() {
		$data = $this->getRequest()->getParams();
		$report = Mage::getModel('report/report');
		if (isset($data['id']) && $data['id']) {
			$report->load($data['id']);
			if ($report->getData('report_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		}
		unset($data['id']);
        //echo "<xmp>";var_dump($data);die();     
		$data['report_company'] = Mage::registry('current_company')->getId();
		$report->addData($data);
		try {
			$report->save();
			$chargeOldArr = explode(',',$data['report_charge_old']);
			$chargeArr = explode(',',$data['report_charge']);
			$ccOldArr = explode(',',$data['report_cc_old']);
			$ccArr = explode(',',$data['report_cc']);
			
			$delChargeArr = array_diff($chargeOldArr,$chargeArr);
			$addChargeArr = array_diff($chargeArr,$chargeOldArr);
			
			$delCcArr = array_diff($ccOldArr,$ccArr);
			$addCcArr = array_diff($ccArr,$ccOldArr);
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');    
			
			$reportId = $report->getId();
			$chargeType = Mage_Report_Model_Link::LINK_TYPE_TO;
			$chargeCc = Mage_Report_Model_Link::LINK_TYPE_CC;
			foreach ($delChargeArr as $v) {
				$v = (int)$v;
				$write->query("delete from report_link where link_report='$reportId' and link_type='$chargeType' and link_user='$v'");  
			}
			foreach ($addChargeArr as $v) {
				$v = (int)$v;
				$write->query("insert into report_link(link_report,link_type,link_user) values('$reportId','$chargeType','$v')");  
			}
			
			foreach ($delCcArr as $v) {
				$v = (int)$v;
				$write->query("delete from report_link where link_report='$reportId' and link_type='$chargeCc' and link_user='$v'");  
			}
			foreach ($addCcArr as $v) {
				$v = (int)$v;
				$write->query("insert into report_link(link_report,link_type,link_user) values('$reportId','$chargeCc','$v')");  
			}
			
			$this->_getSession()->addSuccess('工作报告保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("工作报告保存失败，请联系管理员");
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
    	$report = Mage::getModel('report/report')->load($id);
    	
    	if ($report->getId()) {
    		//判断归属
    		
    		if ($report->getData('report_create')!=$this->_getUser()->getId()) {
    			$this->_getSession()->addError('非法操作！');
    			$this->_redirect('*/*');
    		}
    	}
    	Mage::register('current_report',$report);
        
        $this->loadLayout();
        if ($report->getId()) {
        	$this->_title($this->__('编辑工作报告'));
        } else {
        	$this->_title($this->__('新建工作报告'));
        }
        Mage::register('current_filter','submitto');
        $this->_setActiveMenu('report/submit');
        $this->_addContent($this->getLayout()->createBlock('report/adminhtml_report_edit', 'report.edit'));
        $this->renderLayout();
    }
    
    public function viewAction() {
    	$id = (int)$this->getRequest()->getParam('id');
    	$report = Mage::getModel('report/report')->load($id);
    	$back = $this->getRequest()->getParam('back');
    	$back = $back ? $back : 'submit';
    	Mage::register('current_report',$report);
    	if ($report->getId()) {
    		 $this->_title($this->__('查看工作报告'));
	        $this->loadLayout();
	        $this->_setActiveMenu('report/'.$back);
	        $this->_addContent($this->getLayout()->createBlock('report/adminhtml_report_view', 'report.view'));
	        $this->renderLayout();
    	} else {
    		$this->_getSession()->addError('工作报告已不存在，请重试。');
			$this->_redirect('*/*');
    	}
    }
    
    /****************** review *******************/
    /*
     * 保存评论
     */
    public function saveReviewAction() {
		$data = $this->getRequest()->getParams();
		$reply = Mage::getModel('report/reply');
		$report = Mage::getModel('report/report');
		if (isset($data['reply_report']) && $data['reply_report']) {
			$report->load($data['reply_report']);
			if ($report->getData('report_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		}
		$data['reply_user'] = Mage::registry('current_user')->getId();
		$reply->addData($data);
		try {
			$reply->save();
			$this->_getSession()->addSuccess('回复提交成功');
		} catch (Exception $e) {
			echo $e->getMessage();die();
			$this->_getSession()->addError("回复保存失败，请联系管理员");
		}
		$this->_redirect('*/*/index');
	}


}
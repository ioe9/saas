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


    


}
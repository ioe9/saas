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
        $this->_setActiveMenu('report');
        
        $this->renderLayout();
    }
	
    public function ajaxBlockAction()
    {
        $output   = '';
        $blockTab = $this->getRequest()->getParam('block');
        if (in_array($blockTab, array('tab_orders', 'tab_amounts', 'totals'))) {
            $output = $this->getLayout()->createBlock('adminhtml/dashboard_' . $blockTab)->toHtml();
        }
        $this->getResponse()->setBody($output);
        return;
    }
    

}
<?php
/***
 * 考勤
 */
class Mage_Adminhtml_AttendanceController extends Mage_Adminhtml_Controller_Attendance
{
    public function indexAction()
    {
        $this->_title($this->__('考勤管理'));
        $this->loadLayout();
        $this->_setActiveMenu('attendance');
        
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
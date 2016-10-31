<?php
/***
 * Task 首页
 */
class Mage_Adminhtml_TaskController extends Mage_Adminhtml_Controller_Task
{
    public function indexAction()
    {
        $this->_title($this->__('任务管理'));
        $this->loadLayout();
        $this->_setActiveMenu('task');
        
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



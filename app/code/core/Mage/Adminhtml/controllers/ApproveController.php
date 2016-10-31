<?php
/***
 * 审批管理
 */
class Mage_Adminhtml_ApproveController extends Mage_Adminhtml_Controller_Approve
{
    public function indexAction()
    {
        $this->_title($this->__('审批管理'));
        $this->loadLayout();
        $this->_setActiveMenu('approve');
        
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
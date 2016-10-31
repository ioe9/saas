<?php
/***
 * CRM 首页
 */
class Mage_Adminhtml_CrmController extends Mage_Adminhtml_Controller_Crm
{
    public function indexAction()
    {
        $this->_title($this->__('CRM 管理'));
        $this->loadLayout();
        $this->_setActiveMenu('crm');
        
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
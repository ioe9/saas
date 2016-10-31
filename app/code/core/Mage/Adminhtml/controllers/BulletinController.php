<?php
/***
 * 企业公告
 */
class Mage_Adminhtml_BulletinController extends Mage_Adminhtml_Controller_Bulletin
{
    public function indexAction()
    {
        $this->_title($this->__('企业公告管理'));
        $this->loadLayout();
        $this->_setActiveMenu('bulletin');
        
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
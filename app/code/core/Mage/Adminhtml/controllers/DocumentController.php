<?php
/***
 * 文档管理
 */
class Mage_Adminhtml_DocumentController extends Mage_Adminhtml_Controller_Document
{
    public function indexAction()
    {
        $this->_title($this->__('文档管理'));
        $this->loadLayout();
        $this->_setActiveMenu('document');
        
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
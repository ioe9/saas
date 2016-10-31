<?php
/***
 * EDM首页
 */
class Mage_Adminhtml_EdmController extends Mage_Adminhtml_Controller_Edm
{
    public function indexAction()
    {
        $this->_title($this->__('EDM管理'));
        $this->loadLayout();
        $this->_setActiveMenu('edm');
        
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

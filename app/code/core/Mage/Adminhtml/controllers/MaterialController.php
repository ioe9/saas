<?php
/***
 * 物资管理首页
 */
class Mage_Adminhtml_MaterialController extends Mage_Adminhtml_Controller_Material
{
    public function indexAction()
    {
        $this->_title($this->__('物资管理'));
        $this->loadLayout();
        $this->_setActiveMenu('material');
        
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
<?php
/***
 * 外贸学院首页
 */
class Mage_Adminhtml_CollegeController extends Mage_Adminhtml_Controller_College
{
    public function indexAction()
    {
        $this->_title($this->__('外贸学院 - 外贸人的大学堂'));
        $this->loadLayout();
        $this->_setActiveMenu('edm/index');
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

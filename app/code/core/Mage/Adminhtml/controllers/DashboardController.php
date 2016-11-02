<?php
class Mage_Adminhtml_DashboardController extends Mage_Adminhtml_Controller_Dashboard
{
    public function indexAction()
    {	
        $this->_title($this->__('工作面板'));
        $this->loadLayout();
        $this->_setActiveMenu('edm');
        
        $this->renderLayout();
    }
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('dashboard');
    }
}

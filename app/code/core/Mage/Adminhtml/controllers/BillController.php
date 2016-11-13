<?php
/***
 * Bill 首页
 */
class Mage_Adminhtml_BillController extends Mage_Adminhtml_Controller_Bill
{
    public function indexAction()
    {
        $this->_title($this->__('费用管理'));
        $this->loadLayout();
        $this->_setActiveMenu('bill');
        
        $this->renderLayout();
    }


}
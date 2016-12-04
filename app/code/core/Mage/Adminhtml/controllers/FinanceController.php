<?php
/***
 * 
 */
class Mage_Adminhtml_FinanceController extends Mage_Adminhtml_Controller_Finance
{
    public function indexAction()
    {
        $this->_title($this->__("财务"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

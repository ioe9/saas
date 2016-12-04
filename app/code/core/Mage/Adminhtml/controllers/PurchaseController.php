<?php
/***
 * 
 */
class Mage_Adminhtml_PurchaseController extends Mage_Adminhtml_Controller_Purchase
{
    public function indexAction()
    {
        $this->_title($this->__("采购"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

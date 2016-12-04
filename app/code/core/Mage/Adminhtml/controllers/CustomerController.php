<?php
/***
 * 
 */
class Mage_Adminhtml_CustomerController extends Mage_Adminhtml_Controller_Customer
{
    public function indexAction()
    {
        $this->_title($this->__("客户"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

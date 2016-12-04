<?php
/***
 * 
 */
class Mage_Adminhtml_SalesController extends Mage_Adminhtml_Controller_Sales
{
    public function indexAction()
    {
        $this->_title($this->__("销售"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

<?php
/***
 * 
 */
class Mage_Adminhtml_CsController extends Mage_Adminhtml_Controller_Cs
{
    public function indexAction()
    {
        $this->_title($this->__("客服"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

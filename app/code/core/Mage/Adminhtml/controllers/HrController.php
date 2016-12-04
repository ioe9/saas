<?php
/***
 * 
 */
class Mage_Adminhtml_HrController extends Mage_Adminhtml_Controller_Hr
{
    public function indexAction()
    {
        $this->_title($this->__("人力资源"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

<?php
/***
 * 
 */
class Mage_Adminhtml_WikiController extends Mage_Adminhtml_Controller_Wiki
{
    public function indexAction()
    {
        $this->_title($this->__("百科"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

<?php
/***
 * 
 */
class Mage_Adminhtml_NewsController extends Mage_Adminhtml_Controller_News
{
    public function indexAction()
    {
        $this->_title($this->__("外贸头条"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

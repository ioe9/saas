<?php
/***
 * 
 */
class Mage_Adminhtml_LiveController extends Mage_Adminhtml_Controller_Live
{
    public function indexAction()
    {
        $this->_title($this->__("直播"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

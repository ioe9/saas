<?php
/***
 * 
 */
class Mage_Adminhtml_DomesticController extends Mage_Adminhtml_Controller_Domestic
{
    public function indexAction()
    {
        $this->_title($this->__("内销"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

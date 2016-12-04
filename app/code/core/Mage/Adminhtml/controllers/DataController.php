<?php
/***
 * 
 */
class Mage_Adminhtml_DataController extends Mage_Adminhtml_Controller_Data
{
    public function indexAction()
    {
        $this->_title($this->__("大数据"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

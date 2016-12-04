<?php
/***
 * 
 */
class Mage_Adminhtml_ToolController extends Mage_Adminhtml_Controller_Tool
{
    public function indexAction()
    {
        $this->_title($this->__("工具箱"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

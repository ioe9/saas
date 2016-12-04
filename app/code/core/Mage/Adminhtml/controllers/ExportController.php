<?php
/***
 * 
 */
class Mage_Adminhtml_ExportController extends Mage_Adminhtml_Controller_Export
{
    public function indexAction()
    {
        $this->_title($this->__("出口业务"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->_addContent($this->getLayout()->createBlock('adminhtml/template', 'index')->setTemplate('export/index.phtml'));
        $this->renderLayout();
    }

}

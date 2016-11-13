<?php
/***
 * 文档管理
 */
class Mage_Adminhtml_DocumentController extends Mage_Adminhtml_Controller_Document
{
    public function indexAction()
    {
        $this->_forward('dir');
    }
    
    public function dirAction()
    {
        $this->_title($this->__('文件目录'));
        $this->loadLayout();
        $this->_setActiveMenu('document/dir');
        $this->_addContent($this->getLayout()->createBlock('document/adminhtml_dir', 'dir'));
        $this->renderLayout();
    }
}
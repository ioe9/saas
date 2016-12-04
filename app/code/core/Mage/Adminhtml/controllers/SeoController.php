<?php
/***
 * 
 */
class Mage_Adminhtml_SeoController extends Mage_Adminhtml_Controller_Seo
{
    public function indexAction()
    {
        $this->_title($this->__("SEO"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

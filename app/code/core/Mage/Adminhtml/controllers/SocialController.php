<?php
/***
 * 
 */
class Mage_Adminhtml_SocialController extends Mage_Adminhtml_Controller_Social
{
    public function indexAction()
    {
        $this->_title($this->__("社交应用"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

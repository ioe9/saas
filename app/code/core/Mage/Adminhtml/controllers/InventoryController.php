<?php
/***
 * 
 */
class Mage_Adminhtml_InventoryController extends Mage_Adminhtml_Controller_Inventory
{
    public function indexAction()
    {
        $this->_title($this->__("库存"));
        $this->loadLayout();
        $this->_setActiveMenu("index");
        $this->renderLayout();
    }

}

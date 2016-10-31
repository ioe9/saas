<?php
class Mage_Core_IndexController extends Mage_Core_Controller_Front_Action {

    function indexAction()
    {
        $this->_forward('noRoute');
    }
}

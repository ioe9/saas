<?php
class Mage_Adminhtml_Block_Setting_Tree_User_Chooser extends Mage_Adminhtml_Block_Template
{

    /**
     * Initialize template and cache settings
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('setting/tree/user/chooser.phtml');
    }
}

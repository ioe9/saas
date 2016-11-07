<?php
class Mage_Adminhtml_Block_Setting_Organization_User_Setting extends Mage_Adminhtml_Block_Template {
	protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('setting/organization/user/setting.phtml');
    }
}
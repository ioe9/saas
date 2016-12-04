<?php


class Mage_Adminhtml_Block_Denied extends Mage_Adminhtml_Block_Template
{
    public function hasAvailaleResources()
    {
        $user = Mage::getSingleton('admin/session')->getUser();
        if ($user && $user->hasAvailableResources()) {
            return true;
        }
        return false;
    }
}

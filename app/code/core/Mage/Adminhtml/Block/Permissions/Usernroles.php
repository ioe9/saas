<?php

class Mage_Adminhtml_Block_Permissions_UsernRoles extends Mage_Adminhtml_Block_Template
{

    public function __construct() {
        parent::__construct();
        $userCollection = Mage::getModel("permissions/users")->getCollection()->load();
        $rolesCollection = Mage::getModel("permissions/roles")->getCollection()->load();

        $this->setTemplate('permissions/usernroles.phtml')
            ->assign('users', $userCollection)
            ->assign('roles', $rolesCollection);
    }

}

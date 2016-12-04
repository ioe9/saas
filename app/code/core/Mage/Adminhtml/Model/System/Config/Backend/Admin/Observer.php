<?php


class Mage_Adminhtml_Model_System_Config_Backend_Admin_Observer
{
    /**
     * Log out user and redirect him to new admin custom url
     *
     * @param Varien_Event_Observer $observer
     */
    public function afterCustomUrlChanged($observer)
    {
        if (is_null(Mage::registry('custom_admin_path_redirect'))) {
            return;
        }

        /** @var $adminSession Mage_Admin_Model_Session */
        $adminSession = Mage::getSingleton('admin/session');
        $adminSession->unsetAll();
        $adminSession->getCookie()->delete($adminSession->getSessionName());

        $route = ((bool)(string)Mage::getConfig()->getNode(Mage_Adminhtml_Helper_Data::XML_PATH_USE_CUSTOM_ADMIN_PATH))
            ? Mage::getConfig()->getNode(Mage_Adminhtml_Helper_Data::XML_PATH_CUSTOM_ADMIN_PATH)
            : Mage::getConfig()->getNode(Mage_Adminhtml_Helper_Data::XML_PATH_ADMINHTML_ROUTER_FRONTNAME);

        Mage::app()->getResponse()
            ->setRedirect(Mage::getBaseUrl() . $route)
            ->sendResponse();
        exit(0);
    }
}

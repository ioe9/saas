<?php
/**
 * Adminhtml header block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Page_Header extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('page/header.phtml');
    }

    public function getHomeLink()
    {
        return $this->getUrl('adminhtml');
    }

    public function getUser()
    {
        return Mage::getSingleton('admin/session')->getUser();
    }

    public function getLogoutLink()
    {
        return $this->getUrl('adminhtml/index/logout');
    }

    /**
     * Check if noscript notice should be displayed
     *
     * @return boolean
     */
    public function displayNoscriptNotice()
    {
        return Mage::getStoreConfig('web/browser_capabilities/javascript');
    }

}

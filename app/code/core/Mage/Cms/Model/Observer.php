<?php
/**
 *
 * @category    Mage
 * @package     Mage_Cms
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * CMS Observer model
 *
 * @category   Mage
 * @package    Mage_Cms
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Cms_Model_Observer
{
    /**
     * Modify No Route Forward object
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Cms_Model_Observer
     */
    public function noRoute(Varien_Event_Observer $observer)
    {
        $observer->getEvent()->getStatus()
            ->setLoaded(true)
            ->setForwardModule('cms')
            ->setForwardController('index')
            ->setForwardAction('noRoute');
        return $this;
    }

    /**
     * Modify no Cookies forward object
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Cms_Model_Observer
     */
    public function noCookies(Varien_Event_Observer $observer)
    {
        $redirect = $observer->getEvent()->getRedirect();

        $pageId  = Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_NO_COOKIES_PAGE);
        $pageUrl = Mage::helper('cms/page')->getPageUrl($pageId);

        if ($pageUrl) {
            $redirect->setRedirectUrl($pageUrl);
        }
        else {
            $redirect->setRedirect(true)
                ->setPath('cms/index/noCookies')
                ->setArguments(array());
        }
        return $this;
    }
}

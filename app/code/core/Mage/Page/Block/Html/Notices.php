<?php
/**
 * Html notices block
 *
 * @category    Mage
 * @package     Mage_Page
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Page_Block_Html_Notices extends Mage_Core_Block_Template
{
    /**
     * Check if noscript notice should be displayed
     *
     * @return boolean
     */
    public function displayNoscriptNotice()
    {
        return Mage::getStoreConfig('web/browser_capabilities/javascript');
    }

    /**
     * Check if demo store notice should be displayed
     *
     * @return boolean
     */
    public function displayDemoNotice()
    {
        return Mage::getStoreConfig('design/head/demonotice');
    }

    /**
     * Get Link to cookie restriction privacy policy page
     *
     * @return string
     */
    public function getPrivacyPolicyLink()
    {
        return Mage::getUrl('privacy-policy-cookie-restriction-mode');
    }
}

<?php
/**
 * Admin Data Helper
 *
 * @category    Mage
 * @package     Mage_Admin
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Admin_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Configuration path to expiration period of reset password link
     */
    const XML_PATH_ADMIN_RESET_PASSWORD_LINK_EXPIRATION_PERIOD
        = 'default/admin/emails/password_reset_link_expiration_period';

    /**
     * Generate unique token for reset password confirmation link
     *
     * @return string
     */
    public function generateResetPasswordLinkToken()
    {
        return Mage::helper('core')->uniqHash();
    }

    /**
     * Retrieve customer reset password link expiration period in days
     *
     * @return int
     */
    public function getResetPasswordLinkExpirationPeriod()
    {
        return (int) Mage::getConfig()->getNode(self::XML_PATH_ADMIN_RESET_PASSWORD_LINK_EXPIRATION_PERIOD);
    }
}

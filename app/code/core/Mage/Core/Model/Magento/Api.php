<?php
/**
 * Magento info API
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Model_Magento_Api extends Mage_Api_Model_Resource_Abstract
{
    /**
     * Retrieve information about current Magento installation
     *
     * @return array
     */
    public function info()
    {
        $result = array();
        $result['magento_edition'] = Mage::getEdition();
        $result['magento_version'] = Mage::getVersion();

        return $result;
    }
}

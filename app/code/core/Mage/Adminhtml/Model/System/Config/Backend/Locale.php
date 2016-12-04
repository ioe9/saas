<?php
/**
 * Config locale allowed currencies backend
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Backend_Locale extends Mage_Core_Model_Config_Data
{

    /**
     * Enter description here...
     *
     * @return Mage_Adminhtml_Model_System_Config_Backend_Locale
     */
    protected function _afterSave()
    {
        $collection = Mage::getModel('core/config_data')
            ->getCollection()
            ->addPathFilter('currency/options');

        $values     = explode(',', $this->getValue());
        $exceptions = array();

        foreach ($collection as $data) {
            $match = false;
            $scopeName = Mage::helper('adminhtml')->__('Default scope');

            if (preg_match('/(base|default)$/', $data->getPath(), $match)) {
                if (!in_array($data->getValue(), $values)) {
                    $currencyName = Mage::app()->getLocale()->currency($data->getValue())->getName();
                    if ($match[1] == 'base') {
                        $fieldName = Mage::helper('adminhtml')->__('Base currency');
                    }
                    else {
                        $fieldName = Mage::helper('adminhtml')->__('Display default currency');
                    }

                    switch ($data->getScope()) {
                        case 'default':
                            $scopeName = Mage::helper('adminhtml')->__('Default scope');
                            break;

                        case 'website':
                            $websiteName = Mage::getModel('core/website')->load($data->getScopeId())->getName();
                            $scopeName = Mage::helper('adminhtml')->__('website(%s) scope', $websiteName);
                            break;

                        case 'store':
                            $storeName = Mage::getModel('core/store')->load($data->getScopeId())->getName();
                            $scopeName = Mage::helper('adminhtml')->__('store(%s) scope', $storeName);
                            break;
                    }

                    $exceptions[] = Mage::helper('adminhtml')->__('Currency "%s" is used as %s in %s.', $currencyName, $fieldName, $scopeName);
                }
            }
        }
        if ($exceptions) {
            Mage::throwException(join("\n", $exceptions));
        }

        return $this;
    }

}

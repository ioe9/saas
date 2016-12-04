<?php
/**
 * Variable observer
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Model_Variable_Observer
{
    /**
     * Add variable wysiwyg plugin config
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Core_Model_Variable_Observer
     */
    public function prepareWysiwygPluginConfig(Varien_Event_Observer $observer)
    {
        $config = $observer->getEvent()->getConfig();

        if ($config->getData('add_variables')) {
            $settings = Mage::getModel('core/variable_config')->getWysiwygPluginSettings($config);
            $config->addData($settings);
        }
        return $this;
    }
}

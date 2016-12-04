<?php
/**
 * Design package collection
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Model_Resource_Design_Package_Collection extends Varien_Object
{
    /**
     * Load design package collection
     *
     * @return Mage_Core_Model_Resource_Design_Package_Collection
     */
    public function load()
    {
        $packages = $this->getData('packages');
        if (is_null($packages)) {
            $packages = Mage::getModel('core/design_package')->getPackageList();
            $this->setData('packages', $packages);
        }

        return $this;
    }

    /**
     * Convert to option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = array();
        $packages = $this->getData('packages');
        foreach ($packages as $package) {
            $options[] = array('value' => $package, 'label' => $package);
        }
        array_unshift($options, array('value' => '', 'label' => ''));

        return $options;
    }
}

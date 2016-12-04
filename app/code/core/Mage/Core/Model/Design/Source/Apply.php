<?php
/**
 * @deprecated after 1.4.1.0.
 */
class Mage_Core_Model_Design_Source_Apply extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if (!$this->_options) {
            $optionArray = array(
                1 => Mage::helper('core')->__('This category and all its child elements'),
                3 => Mage::helper('core')->__('This category and its products only'),
                4 => Mage::helper('core')->__('This category and its child categories only'),
                2 => Mage::helper('core')->__('This category only')
            );

            foreach ($optionArray as $k=>$label) {
                $this->_options[] = array('value'=>$k, 'label'=>$label);
            }
        }

        return $this->_options;
    }
}

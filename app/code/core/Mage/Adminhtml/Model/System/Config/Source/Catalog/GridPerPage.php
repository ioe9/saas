<?php
/**
 * Catalog products per page on Grid mode source
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Source_Catalog_GridPerPage
{
    public function toOptionArray()
    {
        $result = array();
        $perPageValues = Mage::getConfig()->getNode('frontend/catalog/per_page_values/grid');
        $perPageValues = explode(',', $perPageValues);
        foreach ($perPageValues as $option) {
            $result[] = array('value' => $option, 'label' => $option);
        }
        //$result[] = array('value' => 'all', 'label' => Mage::helper('catalog')->__('All'));
        return $result;
    }
}

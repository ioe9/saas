<?php
/**
 * Catalog search types
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Source_Catalog_Search_Type
{
    public function toOptionArray()
    {
        $types = array(
            Mage_CatalogSearch_Model_Fulltext::SEARCH_TYPE_LIKE     => 'Like',
            Mage_CatalogSearch_Model_Fulltext::SEARCH_TYPE_FULLTEXT => 'Fulltext',
            Mage_CatalogSearch_Model_Fulltext::SEARCH_TYPE_COMBINE  => 'Combine (Like and Fulltext)',
        );
        $options = array();
        foreach ($types as $k => $v) {
            $options[] = array(
                'value' => $k,
                'label' => $v
            );
        }
        return $options;
    }
}

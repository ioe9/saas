<?php
class Mage_Catalog_Model_Config
{
    const XML_PATH_LIST_DEFAULT_SORT_BY     = 'catalog/frontend/default_sort_by';

    protected $_usedInPostListing;
    protected $_usedForSortBy;

    public function getSourceOptionId($source, $value)
    {
        foreach ($source->getAllOptions() as $option) {
            if (strcasecmp($option['label'], $value)==0 || $option['value'] == $value) {
                return $option['value'];
            }
        }
        return null;
    }

    /**
     * Retrieve Post List Default Sort By
     *
     * @param mixed $store
     * @return string
     */
    public function getPostListDefaultSortBy() {
        return Mage::getStoreConfig(self::XML_PATH_LIST_DEFAULT_SORT_BY);
    }
}

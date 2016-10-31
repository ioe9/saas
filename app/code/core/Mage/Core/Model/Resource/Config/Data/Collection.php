<?php
class Mage_Core_Model_Resource_Config_Data_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('core/config_data');
    }

    /**
     *  Add path filter
     *
     * @param string $section
     * @return Mage_Core_Model_Resource_Config_Data_Collection
     */
    public function addPathFilter($section)
    {
        $this->addFieldToFilter('path', array('like' => $section . '/%'));
        return $this;
    }

    /**
     * Add value filter
     *
     * @param int|string $value
     * @return Mage_Core_Model_Resource_Config_Data_Collection
     */
    public function addValueFilter($value)
    {
        $this->addFieldToFilter('value', array('like' => $value));
        return $this;
    }
}

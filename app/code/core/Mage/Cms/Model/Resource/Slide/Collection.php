<?php

class Mage_Cms_Model_Resource_Slide_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('cms/slide');
    }

    /**
     * Returns pairs slide_id - title
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('slide_id', 'title');
    }

    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();

        $countSelect->reset(Varien_Db_Select::GROUP);

        return $countSelect;
    }

    protected function _renderFiltersBefore()
    {

        return parent::_renderFiltersBefore();
    }

}

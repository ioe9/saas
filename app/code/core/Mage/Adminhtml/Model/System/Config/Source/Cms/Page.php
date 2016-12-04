<?php

class Mage_Adminhtml_Model_System_Config_Source_Cms_Page
{

    protected $_options;

    public function toOptionArray()
    {
        if (!$this->_options) {
            $this->_options = Mage::getResourceModel('cms/page_collection')
                ->load()->toOptionIdArray();
        }
        return $this->_options;
    }

}

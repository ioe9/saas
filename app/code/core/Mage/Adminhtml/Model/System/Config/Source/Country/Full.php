<?php



class Mage_Adminhtml_Model_System_Config_Source_Country_Full extends Mage_Adminhtml_Model_System_Config_Source_Country
{
    public function toOptionArray($isMultiselect=false) {
        return parent::toOptionArray(true);
    }
}

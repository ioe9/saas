<?php



class Mage_Adminhtml_Model_System_Config_Source_Currency
{
    protected $_options;

    public function toOptionArray($isMultiselect)
    {
        if (!$this->_options) {
            $this->_options = Mage::app()->getLocale()->getOptionCurrencies();
        }
        $options = $this->_options;
        return $options;
    }
}

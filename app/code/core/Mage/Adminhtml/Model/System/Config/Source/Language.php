<?php



class Mage_Adminhtml_Model_System_Config_Source_Language
{
    protected $_options;
    
    public function toOptionArray($isMultiselect)
    {
        if (!$this->_options) {
            $this->_options = Mage::getResourceModel('core/language_collection')->loadData()->toOptionArray();
        }
        $options = $this->_options;
        if(!$isMultiselect){
            array_unshift($options, array('value'=>'', 'label'=>''));
        }
        return $options;
    }
}

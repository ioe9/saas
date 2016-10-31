<?php
class Mage_Core_Model_Config_Base extends Varien_Simplexml_Config
{
    public function __construct($sourceData=null)
    {
        $this->_elementClass = 'Mage_Core_Model_Config_Element';
        parent::__construct($sourceData);
    }
}

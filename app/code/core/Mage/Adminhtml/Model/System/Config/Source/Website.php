<?php



class Mage_Adminhtml_Model_System_Config_Source_Website
{
    protected $_options;

    public function toOptionArray()
    {
        if (!$this->_options) {
            $this->_options = array();
            foreach (Mage::app()->getWebsites() as $website) {
                $id = $website->getId();
                $name = $website->getName();
                if ($id!=0) {
                    $this->_options[] = array('value'=>$id, 'label'=>$name);
                }
            }
        }
        return $this->_options;
    }
}

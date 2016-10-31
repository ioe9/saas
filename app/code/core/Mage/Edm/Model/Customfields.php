<?php
class Mage_Edm_Model_Customfields extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/customfields');
    }
    
    public function getVariablesOptionArray($withGroup = false)
    {
        /* @var $collection Mage_Core_Model_Mysql4_Variable_Collection */
        $collection = $this->getCollection();
        $variables = array();
        foreach ($collection as $variable) {
            $variables[] = array(
                'value' => '%%' . $variable['name'] . '%%',
                'label' => $variable['name'],
            );
        }
        if ($withGroup && $variables) {
            $variables = array(
                'label' => "联系人属性",
                'value' => $variables
            );
        }
        return $variables;
    }
}

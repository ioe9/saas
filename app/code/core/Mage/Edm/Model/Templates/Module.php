<?php
class Mage_Edm_Model_Templates_Module extends Mage_Core_Model_Abstract
{
	protected $_categoriesOptions = null;

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/templates_module');
    }
    public function getVariablesOptionArray($withGroup = false)
    {
        /* @var $collection Mage_Core_Model_Mysql4_Variable_Collection */
        $collection = $this->getCollection();
        $variables = array();
        foreach ($collection as $variable) {
            $variables[] = array(
                'value' => '[[' . $variable['name'] . ']]',
                'label' => $variable['name'],
            );
        }
        if ($withGroup && $variables) {
            $variables = array(
                'label' => "模块",
                'value' => $variables
            );
        }
        return $variables;
    }
    public function getAsOption() {
    	$collection = $this->getCollection();
    	$arr = array();
    	foreach ($collection as $_c) {
    		$arr[$_c->getId()] = $_c->getName();
    	}
    	return $arr;
    }
    

}

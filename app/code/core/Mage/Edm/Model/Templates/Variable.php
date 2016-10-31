<?php
class Mage_Edm_Model_Templates_Variable extends Mage_Core_Model_Abstract
{
	protected $_categoriesOptions = null;

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/templates_variable');
    }
    public function getVariablesOptionArray($withGroup = false)
    {
        /* @var $collection Mage_Core_Model_Mysql4_Variable_Collection */
        $collection = $this->getCollection();
        $variables = array();
        foreach ($collection as $variable) {
            $variables[] = array(
                'value' => '' . $variable['expr'] . '',
                'label' => $variable['name'],
            );
        }
        if ($withGroup && $variables) {
            $variables = array(
                'label' => "自定义变量",
                'value' => $variables
            );
        }
        return $variables;
    }
}

<?php
class Mage_Edm_Model_Template_Expr extends Mage_Core_Model_Abstract
{
	protected $_categoriesOptions = null;

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/template_expr');
    }
    public function getVariablesOptionArray($withGroup = false)
    {
        /* @var $collection Mage_Core_Model_Mysql4_Variable_Collection */
        $collection = $this->getCollection();
        $variables = array();
        foreach ($collection as $variable) {
            $variables[] = array(
                'value' =>  $variable['content'],
                'label' => $variable['name'],
            );
        }
        if ($withGroup && $variables) {
            $variables = array(
                'label' => "表达式",
                'value' => $variables
            );
        }
        return $variables;
    }
}

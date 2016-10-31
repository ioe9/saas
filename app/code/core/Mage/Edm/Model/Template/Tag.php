<?php
class Mage_Edm_Model_Template_Tag extends Mage_Core_Model_Abstract
{
	protected $_categoriesOptions = null;

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/template_tag');
    }
    public function getVariablesOptionArray($withGroup = false)
    {
        /* @var $collection Mage_Core_Model_Mysql4_Variable_Collection */
        $collection = $this->getCollection();
        $variables = array();
        foreach ($collection as $variable) {
            $variables[] = array(
                'value' => '[%' . $variable['code'] . '%][%/' . $variable['code'] . '%]',
                'label' => $variable['name'],
            );
        }
        if ($withGroup && $variables) {
            $variables = array(
                'label' => "模版标签",
                'value' => $variables
            );
        }
        return $variables;
    }
}

<?php
class Mage_Edm_Model_Company_Advantage extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/company_advantage');
    }
    
    public function getChildrenOption() {
    	$collection = Mage::getResourceModel('edm/company_advantage_option_collection')
    		->addFieldToFilter('advantage_id',$this->getAdvantageId());
		return $collection;
    }
    public function getVariablesOptionArray($withGroup = false)
    {
        /* @var $collection Mage_Core_Model_Mysql4_Variable_Collection */
        $collection = $this->getCollection();
        $variables = array();
        //基本属性
       
        foreach ($collection as $variable) {
            $variables[] = array(
                'value' => '[%' . $variable['name'] . '%]',
                'label' => $variable['name'],
            );
        }
        if ($withGroup && $variables) {
            $variables = array(
                'label' => "客户优势",
                'value' => $variables
            );
        }
        return $variables;
    }
}

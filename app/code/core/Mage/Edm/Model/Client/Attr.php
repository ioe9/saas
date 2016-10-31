<?php
class Mage_Edm_Model_Client_Attr extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/client_attr');
    }
    
    public function getChildrenOption() {
    	$collection = Mage::getResourceModel('edm/client_attr_option_collection')
    		->addFieldToFilter('attr_id',$this->getAttrId());
		return $collection;
    }
    public function getVariablesOptionArray($withGroup = false)
    {
        /* @var $collection Mage_Core_Model_Mysql4_Variable_Collection */
        $collection = $this->getCollection();
        $variables = array();
        
        //基本属性
        $variables[] = array(
            'value' => '[%客户名称%]',
            'label' => "客户名称",
        );
        $variables[] = array(
            'value' => '[%客户产品%]',
            'label' => "客户产品",
        );
        $variables[] = array(
            'value' => '[%客户国家%]',
            'label' => "客户国家",
        );
        $variables[] = array(
            'value' => '[%客户官网%]',
            'label' => "客户官网",
        );
        foreach ($collection as $variable) {
            $variables[] = array(
                'value' => '[%' . $variable['name'] . '%]',
                'label' => $variable['name'],
            );
        }
        if ($withGroup && $variables) {
            $variables = array(
                'label' => "客户属性",
                'value' => $variables
            );
        }
        return $variables;
    }
}

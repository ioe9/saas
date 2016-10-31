<?php
class Mage_Edm_Model_Company_Attr extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/company_attr');
    }
    public function getVariablesOptionArray($withGroup = false)
    {
        /* @var $collection Mage_Core_Model_Mysql4_Variable_Collection */
        $collection = $this->getCollection();
        $variables = array();
        //基本属性
        $variables[] = array(
            'value' => '{%公司名称%}',
            'label' => "公司名称",
        );
        $variables[] = array(
            'value' => '{%联系人%}',
            'label' => "联系人",
        );
        $variables[] = array(
            'value' => '{%联系邮箱%}',
            'label' => "联系邮箱",
        );
        $variables[] = array(
            'value' => '{%公司网址%}',
            'label' => "公司网址",
        );
        
        $variables[] = array(
            'value' => '{%公司地址%}',
            'label' => "公司地址",
        );
        $variables[] = array(
            'value' => '{%推广产品%}',
            'label' => "推广产品",
        );
        foreach ($collection as $variable) {
            $variables[] = array(
                'value' => '{%' . $variable['name'] . '%}',
                'label' => $variable['name'],
            );
        }
        if ($withGroup && $variables) {
            $variables = array(
                'label' => "会员属性",
                'value' => $variables
            );
        }
        return $variables;
    }
}

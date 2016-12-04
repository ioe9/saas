<?php
/**
 * Checkbox grid column filter
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Checkbox extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Select
{
    public function getHtml()
    {
        return '<span class="head-massaction">' . parent::getHtml() . '</span>';
    }

    protected function _getOptions()
    {
        return array(
            array(
                'label' => Mage::helper('adminhtml')->__('Any'),
                'value' => ''
            ),
            array(
                'label' => Mage::helper('adminhtml')->__('Yes'),
                'value' => 1
            ),
            array(
                'label' => Mage::helper('adminhtml')->__('No'),
                'value' => 0
            ),
        );
    }

    public function getCondition()
    {
        if ($this->getValue()) {
            return $this->getColumn()->getValue();
        }
        else {
            return array(
                array('neq'=>$this->getColumn()->getValue()),
                array('is'=>new Magento_Db_Expr('NULL'))
            );
        }
        //return array('like'=>'%'.$this->getValue().'%');
    }
}

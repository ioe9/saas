<?php
/**
 * Adminhtml system template grid type filter
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */

class Mage_Adminhtml_Block_System_Email_Template_Grid_Filter_Type
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Select
{
    protected static $_types = array(
        null                                        =>  null,
        Mage_Newsletter_Model_Template::TYPE_HTML   => 'HTML',
        Mage_Newsletter_Model_Template::TYPE_TEXT   => 'Text',
    );

    protected function _getOptions()
    {
        $result = array();
        foreach (self::$_types as $code => $label) {
            $result[] = array('value' => $code, 'label' => Mage::helper('adminhtml')->__($label));
        }

        return $result;
    }


    public function getCondition()
    {
        if(is_null($this->getValue())) {
            return null;
        }

        return array('eq' => $this->getValue());
    }
}

<?php
/**
 * Adminhtml system templates grid block type item renderer
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */

class Mage_Adminhtml_Block_System_Email_Template_Grid_Renderer_Type
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected static $_types = array(
        Mage_Newsletter_Model_Template::TYPE_HTML    => 'HTML',
        Mage_Newsletter_Model_Template::TYPE_TEXT    => 'Text',
    );
    public function render(Varien_Object $row)
    {

        $str = Mage::helper('adminhtml')->__('Unknown');

        if(isset(self::$_types[$row->getTemplateType()])) {
            $str = self::$_types[$row->getTemplateType()];
        }

        return Mage::helper('adminhtml')->__($str);
    }
}

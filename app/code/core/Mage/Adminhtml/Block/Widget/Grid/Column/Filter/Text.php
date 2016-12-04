<?php
/**
 * Text grid column filter
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Text extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Abstract 
{
    public function getHtml()
    {
        $html = '<div class="field-100"><input type="text" name="'.$this->_getHtmlName().'" id="'.$this->_getHtmlId().'" value="'.$this->getEscapedValue().'" class="input-text no-changes"/></div>';
        return $html;
    }
}

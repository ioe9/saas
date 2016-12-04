<?php
/**
 * Adminhtml grid item renderer line to wrap
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Wrapline
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Default max length of a line at one row
     *
     * @var integer
     */
    protected $_defaultMaxLineLength = 60;

    /**
     * Renders grid column
     *
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $line = parent::_getValue($row);
        $wrappedLine = '';
        $lineLength = $this->getColumn()->getData('lineLength')
            ? $this->getColumn()->getData('lineLength')
            : $this->_defaultMaxLineLength;
        for($i = 0, $n = floor(Mage::helper('core/string')->strlen($line) / $lineLength); $i <= $n; $i++) {
            $wrappedLine .= Mage::helper('core/string')->substr($line, ($lineLength * $i), $lineLength) . "<br />";
        }
        return $wrappedLine;
    }
}

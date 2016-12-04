<?php
/**
 * Grid colum filter block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Abstract extends Mage_Adminhtml_Block_Abstract
    implements Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Interface
{

    /**
     * Column related to filter
     *
     * @var Mage_Adminhtml_Block_Widget_Grid_Column
     */
    protected $_column;

    /**
     * Set column related to filter
     *
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Abstract
     */
    public function setColumn($column)
    {
        $this->_column = $column;
        return $this;
    }

    /**
     * Retrieve column related to filter
     *
     * @return Mage_Adminhtml_Block_Widget_Grid_Column
     */
    public function getColumn()
    {
        return $this->_column;
    }

    /**
     * Retrieve html name of filter
     *
     * @return string
     */
    protected function _getHtmlName()
    {
        return $this->getColumn()->getId();
    }

    /**
     * Retrieve html id of filter
     *
     * @return string
     */
    protected function _getHtmlId()
    {
        return $this->getColumn()->getGrid()->getId() . '_'
            . $this->getColumn()->getGrid()->getVarNameFilter() . '_'
            . $this->getColumn()->getId();
    }

    /**
     * Retrieve escaped value
     *
     * @param mixed $index
     * @return string
     */
    public function getEscapedValue($index = null)
    {
        return htmlspecialchars($this->getValue($index));
    }

    /**
     * Retrieve condition
     *
     * @return array
     */
    public function getCondition()
    {
        $helper = Mage::getResourceHelper('core');
        $likeExpression = $helper->addLikeEscape($this->getValue(), array('position' => 'any'));
        return array('like' => $likeExpression);
    }

    /**
     * @deprecated after 1.5.0.0
     * @param  $value
     * @return mixed
     */
    protected function _escapeValue($value)
    {
        return str_replace('_', '\_', str_replace('\\', '\\\\', $value));
    }

    /**
     * Retrieve filter html
     *
     * @return string
     */
    public function getHtml()
    {
        return '';
    }

}

<?php
/**
 * Grid column filter interface
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
interface Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Interface 
{
    public function getColumn();
    public function setColumn($column);
    public function getHtml();
}

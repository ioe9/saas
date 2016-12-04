<?php
/**
 * Adminhtml grid item renderer
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */

class Mage_Adminhtml_Block_Widget_Grid_Block extends Varien_Filter_Object implements Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Interface
{
    public function render(Varien_Object $row)
    {
        $block->setPageObject($row);
        echo $block->toHtml();
    }
}

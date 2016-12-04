<?php
/**
 * Adminhtml grid item renderer concat
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Mio Core Team <developer@ioe9.com>
 */

class Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Concat
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        $dataArr = array();
        foreach ($this->getColumn()->getIndex() as $index) {
            if ($data = $row->getData($index)) {
                $dataArr[] = $data;
            }
        }
        $data = join($this->getColumn()->getSeparator(), $dataArr);
        // TODO run column type renderer
        return $data;
    }

}

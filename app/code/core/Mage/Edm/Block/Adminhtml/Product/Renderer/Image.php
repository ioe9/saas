<?php
class Mage_Edm_Block_Adminhtml_Product_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Cha $row)
    {
        return '<img src="'.Mage::helper('plan')->getImageUrl($row->getChaImage()).'" alt="'.$row->getChaName().'" height="100">';
    }
}

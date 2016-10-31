<?php
class Mage_Edm_Block_Adminhtml_Email_Renderer_Url extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Cha $row)
    {
        return '<img src="'.Mage::helper('plan/cha')->getChaUrl($row->getChaUrl()).'" alt="'.$row->getChaName().'" height="100">';
    }
}

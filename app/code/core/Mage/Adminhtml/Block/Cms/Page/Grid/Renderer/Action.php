<?php


class Mage_Adminhtml_Block_Cms_Page_Grid_Renderer_Action
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        Mage::dispatchEvent('adminhtml_cms_page_grid_renderer_action_before_render', array('row' => $row));
        if ($row->getPreviewUrl()) {
            $href = $row->getPreviewUrl();
        } else {
            $urlModel = Mage::getModel('core/url');
            $href = $urlModel->getUrl(
                $row->getIdentifier(), array(
                    '_current' => false,
              
               )
            );
        }
        return '<a href="' . $href . '" target="_blank">' . $this->__('Preview') . '</a>';
    }
}

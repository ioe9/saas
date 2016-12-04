<?php
/**
 * Controller for CMS Block Widget plugin
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Edm_Cms_Block_WidgetController extends Mage_Adminhtml_Controller_Edm
{
    /**
     * Chooser Source action
     */
    public function chooserAction()
    {
        $uniqId = $this->getRequest()->getParam('uniq_id');
        $pagesGrid = $this->getLayout()->createBlock('adminhtml/cms_block_widget_chooser', '', array(
            'id' => $uniqId,
        ));
        $this->getResponse()->setBody($pagesGrid->toHtml());
    }

    /**
     * Check is allowed access to action
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/widget_instance');
    }
}

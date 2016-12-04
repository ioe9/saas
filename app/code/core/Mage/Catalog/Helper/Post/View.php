<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog category helper
 *
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Helper_Post_View extends Mage_Core_Helper_Abstract
{
    // List of exceptions throwable during prepareAndRender() method
    public $ERR_NO_PRODUCT_LOADED = 1;
    public $ERR_BAD_CONTROLLER_INTERFACE = 2;

     /**
     * Inits layout for viewing post page
     *
     * @param Mage_Catalog_Model_Post $post
     * @param Mage_Core_Controller_Front_Action $controller
     *
     * @return Mage_Catalog_Helper_Post_View
     */
    public function initPostLayout($post, $controller)
    {
        $design = Mage::getSingleton('catalog/design');
        $settings = $design->getDesignSettings($post);

        if ($settings->getCustomDesign()) {
            $design->applyCustomDesign($settings->getCustomDesign());
        }

        $update = $controller->getLayout()->getUpdate();
        $update->addHandle('default');
        $controller->addActionLayoutHandles();

        $update->addHandle('PRODUCT_TYPE_' . $post->getTypeId());
        $update->addHandle('PRODUCT_' . $post->getId());
        $controller->loadLayoutUpdates();

        // Apply custom layout update once layout is loaded
        $layoutUpdates = $settings->getLayoutUpdates();
        if ($layoutUpdates) {
            if (is_array($layoutUpdates)) {
                foreach($layoutUpdates as $layoutUpdate) {
                    $update->addUpdate($layoutUpdate);
                }
            }
        }

        $controller->generateLayoutXml()->generateLayoutBlocks();

        // Apply custom layout (page) template once the blocks are generated
        if ($settings->getPageLayout()) {
            $controller->getLayout()->helper('page/layout')->applyTemplate($settings->getPageLayout());
        }

        $currentCategory = Mage::registry('current_category');
        $root = $controller->getLayout()->getBlock('root');
        if ($root) {
            $controllerClass = $controller->getFullActionName();
            if ($controllerClass != 'catalog-post-view') {
                $root->addBodyClass('catalog-post-view');
            }
            $root->addBodyClass('post-' . $post->getUrlKey());
            if ($currentCategory instanceof Mage_Catalog_Model_Category) {
                $root->addBodyClass('categorypath-' . $currentCategory->getUrlPath())
                    ->addBodyClass('category-' . $currentCategory->getUrlKey());
            }
        }

        return $this;
    }

    /**
     * Prepares post view page - inits layout and all needed stuff
     *
     * $params can have all values as $params in Mage_Catalog_Helper_Post - initPost().
     * Plus following keys:
     *   - 'buy_request' - Varien_Object holding buyRequest to configure post
     *   - 'specify_options' - boolean, whether to show 'Specify options' message
     *   - 'configure_mode' - boolean, whether we're in Configure-mode to edit post configuration
     *
     * @param int $postId
     * @param Mage_Core_Controller_Front_Action $controller
     * @param null|Varien_Object $params
     *
     * @return Mage_Catalog_Helper_Post_View
     */
    public function prepareAndRender($postId, $controller, $params = null)
    {
        // Prepare data
        $postHelper = Mage::helper('catalog/post');
        if (!$params) {
            $params = new Varien_Object();
        }

        // Standard algorithm to prepare and rendern post view page
        $post = $postHelper->initPost($postId, $controller, $params);
        if (!$post) {
            throw new Mage_Core_Exception($this->__('Post is not loaded'), $this->ERR_NO_PRODUCT_LOADED);
        }

        $buyRequest = $params->getBuyRequest();
        if ($buyRequest) {
            $postHelper->preparePostOptions($post, $buyRequest);
        }

        if ($params->hasConfigureMode()) {
            $post->setConfigureMode($params->getConfigureMode());
        }

        Mage::dispatchEvent('catalog_controller_post_view', array('post' => $post));

        if ($params->getSpecifyOptions()) {
            $notice = $post->getTypeInstance(true)->getSpecifyOptionMessage();
            Mage::getSingleton('catalog/session')->addNotice($notice);
        }

        Mage::getSingleton('catalog/session')->setLastViewedPostId($post->getId());

        $this->initPostLayout($post, $controller);

        $controller->initLayoutMessages(array('catalog/session', 'checkout/session'))
            ->renderLayout();

        return $this;
    }
}

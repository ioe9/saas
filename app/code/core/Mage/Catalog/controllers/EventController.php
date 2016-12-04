<?php
class Mage_Catalog_EventController extends Mage_Core_Controller_Front_Action
{
    /**
     * Current applied design settings
     *
     * @deprecated after 1.4.2.0-beta1
     * @var array
     */
    protected $_designPostSettingsApplied = array();

    /**
     * Initialize requested post object
     *
     * @return Mage_Catalog_Model_Post
     */
    protected function _initPost()
    {
        $categoryId = (int) $this->getRequest()->getParam('category', false);
        $postId  = (int) $this->getRequest()->getParam('id');

        $params = new Varien_Object();
        $params->setCategoryId($categoryId);

        return Mage::helper('catalog/post')->initPost($postId, $this, $params);
    }

    /**
     * Initialize post view layout
     *
     * @param   Mage_Catalog_Model_Post $post
     * @return  Mage_Catalog_PostController
     */
    protected function _initPostLayout($post)
    {
        Mage::helper('catalog/post_view')->initPostLayout($post, $this);
        return $this;
    }

    /**
     * Recursively apply custom design settings to post if it's container
     * category custom_use_for_posts option is setted to 1.
     * If not or post shows not in category - applyes post's internal settings
     *
     * @deprecated after 1.4.2.0-beta1, functionality moved to Mage_Catalog_Model_Design
     * @param Mage_Catalog_Model_Category|Mage_Catalog_Model_Post $object
     * @param Mage_Core_Model_Layout_Update $update
     */
    protected function _applyCustomDesignSettings($object, $update)
    {
        if ($object instanceof Mage_Catalog_Model_Category) {
            // lookup the proper category recursively
            if ($object->getCustomUseParentSettings()) {
                $parentCategory = $object->getParentCategory();
                if ($parentCategory && $parentCategory->getId() && $parentCategory->getLevel() > 1) {
                    $this->_applyCustomDesignSettings($parentCategory, $update);
                }
                return;
            }

            // don't apply to the post
            if (!$object->getCustomApplyToPosts()) {
                return;
            }
        }

        if ($this->_designPostSettingsApplied) {
            return;
        }

        $date = $object->getCustomDesignDate();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if (array_key_exists('from', $date) && array_key_exists('to', $date)
            && $now>=$date['from'] && $now<=$date['to']
        ) {
            if ($object->getPageLayout()) {
                $this->_designPostSettingsApplied['layout'] = $object->getPageLayout();
            }
            $this->_designPostSettingsApplied['update'] = $object->getCustomLayoutUpdate();
        }
    }

    /**
     * Post view action
     */
    public function indexAction()
    {
        $categoryId = (int) $this->getRequest()->getParam('category', false);
        $postId  = (int) $this->getRequest()->getParam('id');
        $specifyOptions = $this->getRequest()->getParam('options');

        $viewHelper = Mage::helper('catalog/post_view');

        $params = new Varien_Object();
        $params->setCategoryId($categoryId);
        $params->setSpecifyOptions($specifyOptions);

        // Render page
        try {
            $viewHelper->prepareAndRender($postId, $this, $params);
            
        } catch (Exception $e) {
            if ($e->getCode() == $viewHelper->ERR_NO_PRODUCT_LOADED) {
                if (isset($_GET['store'])  && !$this->getResponse()->isRedirect()) {
                    $this->_redirect('');
                } elseif (!$this->getResponse()->isRedirect()) {
                    $this->_forward('noRoute');
                }
            } else {
                Mage::logException($e);
                $this->_forward('noRoute');
            }
        }
    }
}

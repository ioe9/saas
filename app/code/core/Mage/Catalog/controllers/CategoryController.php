<?php
class Mage_Catalog_CategoryController extends Mage_Core_Controller_Front_Action
{
    /**
     * Initialize requested category object
     *
     * @return Mage_Catalog_Model_Category
     */
    protected function _initCatagory()
    {
        Mage::dispatchEvent('catalog_controller_category_init_before', array('controller_action' => $this));
        
        $categoryId = (int) $this->getRequest()->getParam('id', false);
        if (!$categoryId) {
            return false;
        }

        $category = Mage::getModel('catalog/category')
            ->load($categoryId);
		if ($category->getData('display_slide') && $category->getData('display_slide_block')) {
			 Mage::register('current_slide', Mage::getModel('cms/slide')->load($category->getData('display_slide_block')));
		}
		
        if (!Mage::helper('catalog/category')->canShow($category)) {
            return false;
        }
        Mage::getSingleton('catalog/session')->setLastVisitedCategoryId($category->getId());
        Mage::register('current_category', $category);
        Mage::register('current_entity_key', $category->getPath());
        
        try {
            Mage::dispatchEvent(
                'catalog_controller_category_init_after',
                array(
                    'category' => $category,
                    'controller_action' => $this
                )
            );
        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            return false;
        }

        return $category;
    }

    /**
     * Recursively apply custom design settings to category if it's option
     * custom_use_parent_settings is setted to 1 while parent option is not
     *
     * @deprecated after 1.4.2.0-beta1, functionality moved to Mage_Catalog_Model_Design
     * @param Mage_Catalog_Model_Category $category
     * @param Mage_Core_Model_Layout_Update $update
     *
     * @return Mage_Catalog_CategoryController
     */
    protected function _applyCustomDesignSettings($category, $update)
    {
        if ($category->getCustomUseParentSettings() && $category->getLevel() > 1) {
            $parentCategory = $category->getParentCategory();
            if ($parentCategory && $parentCategory->getId()) {
                return $this->_applyCustomDesignSettings($parentCategory, $update);
            }
        }

        $validityDate = $category->getCustomDesignDate();
		$now = Mage::getSingleton('core/date')->gmtDate();
        if (array_key_exists('from', $validityDate) &&
            array_key_exists('to', $validityDate) &&
            $now>=$validityDate['from'] && $now<= $validityDate['to']
        ) {
            if ($category->getPageLayout()) {
                $this->getLayout()->helper('page/layout')
                    ->applyHandle($category->getPageLayout());
            }
            $update->addUpdate($category->getCustomLayoutUpdate());
        }

        return $this;
    }

    /**
     * Category view action
     */
    public function viewAction()
    {
        if ($category = $this->_initCatagory()) {
        	
            $design = Mage::getSingleton('catalog/design');
            $settings = $design->getDesignSettings($category);
            Mage::getSingleton('catalog/session')->setLastViewedCategoryId($category->getId());

            $update = $this->getLayout()->getUpdate();
            $update->addHandle('default');

            $this->addActionLayoutHandles();
            $update->addHandle($category->getLayoutUpdateHandle());
            $this->loadLayoutUpdates();

            // apply custom layout update once layout is loaded
            if ($layoutUpdates = $settings->getLayoutUpdates()) {
                if (is_array($layoutUpdates)) {
                    foreach($layoutUpdates as $layoutUpdate) {
                        $update->addUpdate($layoutUpdate);
                    }
                }
            }

            $this->generateLayoutXml()->generateLayoutBlocks();
            // apply custom layout (page) template once the blocks are generated
            if ($settings->getPageLayout()) {
                $this->getLayout()->helper('page/layout')->applyTemplate($settings->getPageLayout());
            }
            $this->renderLayout();
        }
        elseif (!$this->getResponse()->isRedirect()) {
            $this->_forward('noRoute');
        }
    }
}

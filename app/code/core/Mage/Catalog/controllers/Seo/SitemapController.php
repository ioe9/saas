<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * SEO sitemap controller
 *
 * @category   Mage
 * @package    Mage_Catalog
 */
class Mage_Catalog_Seo_SitemapController extends Mage_Core_Controller_Front_Action
{

    /**
     * Check if SEO sitemap is enabled in configuration
     *
     * @return Mage_Catalog_Seo_SitemapController
     */
    public function preDispatch(){
        parent::preDispatch();
        if(!Mage::getStoreConfig('catalog/seo/site_map')){
              $this->_redirect('noroute');
              $this->setFlag('',self::FLAG_NO_DISPATCH,true);
        }
        return $this;
    }

    /**
     * Display categories listing
     *
     */
    public function categoryAction()
    {
        $update = $this->getLayout()->getUpdate();
        $update->addHandle('default');
        $this->addActionLayoutHandles();
        if (Mage::helper('catalog/map')->getIsUseCategoryTreeMode()) {
            $update->addHandle(strtolower($this->getFullActionName()).'_tree');
        }
        $this->loadLayoutUpdates();
        $this->generateLayoutXml()->generateLayoutBlocks();
        $this->renderLayout();
    }

    /**
     * Display posts listing
     *
     */
    public function postAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

}

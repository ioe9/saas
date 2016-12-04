<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Catalog post price block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Mio Core Team <developer@ioe9.com>
 */
 class Mage_Catalog_Block_Post_View_Price extends Mage_Core_Block_Template
 {
    public function getPrice()
    {
        $post = Mage::registry('post');
        /*if($post->isConfigurable()) {
            $price = $post->getCalculatedPrice((array)$this->getRequest()->getParam('super_attribute', array()));
            return Mage::app()->getStore()->formatPrice($price);
        }*/

        return $post->getFormatedPrice();
    }
 }

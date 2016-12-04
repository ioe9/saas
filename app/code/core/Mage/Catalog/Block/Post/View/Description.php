<?php
/**

 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Post description block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Block_Post_View_Description extends Mage_Core_Block_Template
{
    protected $_post = null;

    function getPost()
    {
        if (!$this->_post) {
            $this->_post = Mage::registry('post');
        }
        return $this->_post;
    }
}

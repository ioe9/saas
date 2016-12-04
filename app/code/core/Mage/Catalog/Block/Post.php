<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Mage_Catalog_Block_Post extends Mage_Core_Block_Template
{
    protected $_finalPrice = array();

    public function getPost()
    {
        if (!$this->getData('post') instanceof Mage_Catalog_Model_Post) {
            if ($this->getData('post')->getPostId()) {
                $postId = $this->getData('post')->getPostId();
            }
            if ($postId) {
                $post = Mage::getModel('catalog/post')->load($postId);
                if ($post) {
                    $this->setPost($post);
                }
            }
        }
        return $this->getData('post');
    }

    public function getPrice()
    {
        return $this->getPost()->getPrice();
    }

    public function getFinalPrice()
    {
        if (!isset($this->_finalPrice[$this->getPost()->getId()])) {
            $this->_finalPrice[$this->getPost()->getId()] = $this->getPost()->getFinalPrice();
        }
        return $this->_finalPrice[$this->getPost()->getId()];
    }

    public function getPriceHtml($post)
    {
        $this->setTemplate('catalog/post/price.phtml');
        $this->setPost($post);
        return $this->toHtml();
    }
}

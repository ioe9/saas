<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Post gallery
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Block_Post_Gallery extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {
        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle($this->getPost()->getMetaTitle());
        }
        return parent::_prepareLayout();
    }
    public function getPost()
    {
        return Mage::registry('post');
    }

    public function getGalleryCollection()
    {
        return $this->getPost()->getMediaGalleryImages();
    }

    public function getCurrentImage()
    {
        $imageId = $this->getRequest()->getParam('image');
        $image = null;
        if ($imageId) {
            $image = $this->getGalleryCollection()->getItemById($imageId);
        }

        if (!$image) {
            $image = $this->getGalleryCollection()->getFirstItem();
        }
        return $image;
    }

    public function getImageUrl()
    {
        return $this->getCurrentImage()->getUrl();
    }

    public function getImageFile()
    {
        return $this->getCurrentImage()->getFile();
    }

    /**
     * Retrieve image width
     *
     * @return bool|int
     */
    public function getImageWidth()
    {
        $file = $this->getCurrentImage()->getPath();
        if (file_exists($file)) {
            $size = getimagesize($file);
            if (isset($size[0])) {
                if ($size[0] > 600) {
                    return 600;
                } else {
                    return $size[0];
                }
            }
        }

        return false;
    }

    public function getPreviusImage()
    {
        $current = $this->getCurrentImage();
        if (!$current) {
            return false;
        }
        $previus = false;
        foreach ($this->getGalleryCollection() as $image) {
            if ($image->getValueId() == $current->getValueId()) {
                return $previus;
            }
            $previus = $image;
        }
        return $previus;
    }

    public function getNextImage()
    {
        $current = $this->getCurrentImage();
        if (!$current) {
            return false;
        }

        $next = false;
        $currentFind = false;
        foreach ($this->getGalleryCollection() as $image) {
            if ($currentFind) {
                return $image;
            }
            if ($image->getValueId() == $current->getValueId()) {
                $currentFind = true;
            }
        }
        return $next;
    }

    public function getPreviusImageUrl()
    {
        if ($image = $this->getPreviusImage()) {
            return $this->getUrl('*/*/*', array('_current'=>true, 'image'=>$image->getValueId()));
        }
        return false;
    }

    public function getNextImageUrl()
    {
        if ($image = $this->getNextImage()) {
            return $this->getUrl('*/*/*', array('_current'=>true, 'image'=>$image->getValueId()));
        }
        return false;
    }
}

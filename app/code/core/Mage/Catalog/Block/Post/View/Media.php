<?php
/**
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Simple post data view
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Catalog_Block_Post_View_Media extends Mage_Catalog_Block_Post_View_Abstract
{
    /**
     * Flag, that defines whether gallery is disabled
     *
     * @var boolean
     */
    protected $_isGalleryDisabled;

    /**
     * Retrieve list of gallery images
     *
     * @return array|Varien_Data_Collection
     */
    public function getGalleryImages()
    {
        if ($this->_isGalleryDisabled) {
            return array();
        }
        $collection = $this->getPost()->getMediaGalleryImages();
        return $collection;
    }

    /**
     * Retrieve gallery url
     *
     * @param null|Varien_Object $image
     * @return string
     */
    public function getGalleryUrl($image = null)
    {
        $params = array('id' => $this->getPost()->getId());
        if ($image) {
            $params['image'] = $image->getValueId();
        }
        return $this->getUrl('catalog/post/gallery', $params);
    }

    /**
     * Retrieve gallery image url
     *
     * @param null|Varien_Object $image
     * @return string
     */
    public function getGalleryImageUrl($image)
    {
        if ($image) {
            $helper = $this->helper('catalog/image')
                ->init($this->getPost(), 'image', $image->getFile())
                ->keepFrame(false);

            $size = Mage::getStoreConfig(Mage_Catalog_Helper_Image::XML_NODE_PRODUCT_BASE_IMAGE_WIDTH);
            if (is_numeric($size)) {
                $helper->constrainOnly(true)->resize($size);
            }
            return (string)$helper;
        }
        return null;
    }

    /**
     * Retrieve visibility of gallery image based on gallery filter where present
     *
     * @param null|Varien_Object $image
     * @return bool
     */
    public function isGalleryImageVisible($image)
    {
        if (($filterClass = $this->getGalleryFilterHelper()) && ($filterMethod = $this->getGalleryFilterMethod())) {
            return Mage::helper($filterClass)->$filterMethod($this->getPost(), $image);
        }
        return true;
    }

    /**
     * Disable gallery
     */
    public function disableGallery()
    {
        $this->_isGalleryDisabled = true;
    }
}

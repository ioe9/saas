<?php
class Mage_College_Model_Article extends Mage_Core_Model_Abstract
{
	const MEDIA_IMAGE_PREFIX = 'article/detail';
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('college/article');
    }
    
    public function getImageUrl() {
    	$urlSuffix = $this->getArticleImage();
    	return $this->getImageUrlPrefix().$urlSuffix;
    }
	
	public function getImageUrlPrefix() {
		return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).self::MEDIA_IMAGE_PREFIX.'/';
	}
}

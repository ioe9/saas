<?php
class Mage_Edm_Model_Article_Wx extends Mage_Core_Model_Abstract
{
	const MEDIA_IMAGE_PREFIX = 'article/wx';
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/article_wx');
    }
    
    public function getImageUrl() {
    	$urlSuffix = $this->getImage();
    	return $this->getImageUrlPrefix().$urlSuffix;
    }
	
	public function getImageUrlPrefix() {
		return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).self::MEDIA_IMAGE_PREFIX.'/';
	}
}

<?php
class Mage_Report_Model_Reply extends Mage_Core_Model_Abstract
{
	const MEDIA_IMAGE_PREFIX = 'report/reply';
    
    protected function _construct()
    {
        $this->_init('report/reply');
    }
    
    public function getImageUrl() {
    	$urlSuffix = $this->getImage();
    	return $this->getImageUrlPrefix().$urlSuffix;
    }
	
	public function getImageUrlPrefix() {
		return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).self::MEDIA_IMAGE_PREFIX.'/';
	}
}

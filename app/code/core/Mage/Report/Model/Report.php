<?php
class Mage_Report_Model_Report extends Mage_Core_Model_Abstract
{
	const MEDIA_IMAGE_PREFIX = 'report';
    
    protected function _construct()
    {
        $this->_init('report/report');
    }
    
    public function getImageUrl() {
    	$urlSuffix = $this->getImage();
    	return $this->getImageUrlPrefix().$urlSuffix;
    }
	
	public function getImageUrlPrefix() {
		return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).self::MEDIA_IMAGE_PREFIX.'/';
	}
	
	/***
	 * 获取汇报对象
	 */
	public function getReportObject() {
		return Mage::getModel('report/link')->getReportLink($this->getId());
	}
	/***
	 * 获取汇报对象
	 */
	public function getReportCc() {
		return Mage::getModel('report/link')->getReportLink($this->getId(),Mage_Report_Model_Link::LINK_TYPE_CC);
	}
	
	    
	
}

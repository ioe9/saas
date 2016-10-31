<?php
/***
 * cache操作
 */
class Mage_Edm_Helper_Front_Cache extends Mage_Core_Helper_Abstract
{
	protected $_cacheGroup = 'edm_cache';
    public function saveToCache($data, $cacheKey, $cacheTags=array(), $lifeTime = 86400)
    {
        $cacheGroup = $this->_cacheGroup;
        $useCache = Mage::app()->useCache($cacheGroup);
        if(!$useCache || !$cacheKey) {
            return false;
        }
        $cacheTags = array_merge(array('INS_CACHE_TAG'), $cacheTags);
        Mage::app()->saveCache($data, $cacheKey, $cacheTags, $lifeTime);
    }

    public function loadCache($cacheKey = '')
    {
        $cacheGroup = $this->_cacheGroup;
        $useCache = Mage::app()->useCache($cacheGroup);
        if(!$useCache || !$cacheKey) {
            return false;
        }
        return Mage::app()->loadCache($cacheKey);
    }

    public function getCacheKey($suffix)
    {
        return 'INS_CACHE_' . $suffix;
    }
}
?>

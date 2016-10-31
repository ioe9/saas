<?php
class Mage_Edm_Helper_Front_Base extends Mage_Core_Helper_Abstract
{
	public function formatUrl($url) {
		if (!$url) {
			return false;
		}
		$url = str_replace(array('https://','http://'),'',$url);
		$urlArr = explode('/',$url);
		$url = $urlArr[0];
		if (strstr($url,'www')) {
			return $url;
			
		} else {
			return 'www.'.$url;
		}
	}
}
?>

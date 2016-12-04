<?php
class Mage_Edm_Model_Template_Scene extends Mage_Core_Model_Abstract
{
	const STATUS_ENABLE = 1;
	const STATUS_EISABLE = 0;
	const MEDIA_IMAGE_PREFIX = 'edm/template/scene';
	
	const SCENE_DEVELOP = 1;
    protected function _construct()
    {
        $this->_init("edm/template_scene");
    }
	
	public function getScenes($parentId = 0) {
		$parentId = (int)$parentId;
		$collection = $this->getCollection()
			->addFieldToFilter('scene_status',self::STATUS_ENABLE)
			->addFieldToFilter('scene_parent',$parentId)
			->setOrder('scene_position','desc');
		return $collection;
	}
	
	public function getAsOptions() {
		$collection = $this->getScenes();
		$arr = array();
		foreach ($collection as $item) {
			$arr[$item->getId()] = $item->getSceneName();
			//array_push($arr,);
		}
		return $arr;
	}
    public function getImageUrl() {
    	$urlSuffix = $this->getSceneImage();
    	return $this->getImageUrlPrefix().$urlSuffix;
    }
	
	public function getImageUrlPrefix() {
		return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).self::MEDIA_IMAGE_PREFIX.'/';
	}
}

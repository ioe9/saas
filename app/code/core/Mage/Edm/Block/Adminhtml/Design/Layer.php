<?php
class Mage_Edm_Block_Adminhtml_Design_Layer extends Mage_Core_Block_Template
{
	protected $_collection;
	protected function _prepareLayout()
    {
		$this->getCollection();
    }

	public function getCollection(){
		if (!$this->_collection) {
			$collection = Mage::getSingleton('edm/design_layer')
				->getCollection();
			$this->_collection = $collection;
		}
		return $this->_collection;
	}
	
	public function getScenes() {
		return Mage::getResourceModel('edm/template_scene_collection')
			->addFieldToFilter('scene_status',Mage_Edm_Model_Template_Scene::STATUS_ENABLE)
			//->addFieldToFilter('scene_company',0)
			->setOrder('scene_position','desc');
	}
}

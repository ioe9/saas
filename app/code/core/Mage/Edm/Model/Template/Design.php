<?php
class Mage_Edm_Model_Template_Design extends Mage_Core_Model_Abstract
{
	protected $_categoriesOptions = null;

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/template_design');
    }
    public function getAsOption() {
    	$collection = $this->getCollection();
    	$arr = array('' => ' -- 请选择 -- ');
    	foreach ($collection as $_c) {
    		$arr[$_c->getId()] = $_c->getName();
    	}
    	return $arr;
    }
    
    public function getImageUrl() {
    	return Mage::getBaseUrl('media').$this->getData('design_image');
    }
}

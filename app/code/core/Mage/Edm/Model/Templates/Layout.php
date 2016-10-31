<?php
class Mage_Edm_Model_Templates_Layout extends Mage_Core_Model_Abstract
{
	protected $_categoriesOptions = null;

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/templates_layout');
    }
    public function getAsOption() {
    	$collection = $this->getCollection();
    	$arr = array('' => ' -- 请选择 -- ');
    	foreach ($collection as $_c) {
    		$arr[$_c->getId()] = $_c->getName();
    	}
    	return $arr;
    }
}

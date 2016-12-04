<?php
class Mage_College_Model_Article_Layer extends Varien_Object
{
	protected $_collection;
    public function getCollection()
    {
    	if (!$this->_collection) {
    		$collection = Mage::getResourceModel('college/article_collection');
    		$this->_collection = $collection;
    	}
        return $this->_collection;
    }
}

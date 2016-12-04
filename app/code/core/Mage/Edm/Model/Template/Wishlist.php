<?php
class Mage_Edm_Model_Template_Wishlist extends Mage_Core_Model_Abstract
{
	const TYPE_TEMPLATE = 0;
	const TYPE_DESIGN = 1;
    protected function _construct()
    {
        $this->_init("edm/template_wishlist");
    }
	
}

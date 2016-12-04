<?php
class Mage_College_Block_Adminhtml_Article_View extends Mage_Core_Block_Template
{
	protected function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

	public function getDetail(){
		return Mage::registry('current_article');
	}
}

<?php
class Mage_Edm_Block_Adminhtml_Community_Article_List extends Mage_Core_Block_Template
{
	protected $_collection;
	protected function _prepareLayout()
    {
		$pager = $this->getLayout()->createBlock('page/html_pager', 'pager');
		$pager->setLimit(18);
		$pager->setCollection($this->getCollection());
		
		$this->setChild('pager', $pager);
		return parent::_prepareLayout();
    }

	public function getCollection(){
		if (!$this->_collection) {
			$collection = Mage::getSingleton('edm/community_article_layer')
				->getCollection();
			$collection->setOrder('position','desc');
			$this->_collection = $collection;
		}
		return $this->_collection;
	}
}

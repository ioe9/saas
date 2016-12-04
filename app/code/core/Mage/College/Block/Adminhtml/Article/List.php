<?php
class Mage_College_Block_Adminhtml_Article_List extends Mage_Core_Block_Template
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
			$collection = Mage::getSingleton('college/article_layer')
				->getCollection();
			$collection->setOrder('position','desc');
			$category = Mage::registry('current_category');
			if ($category && $category->getId()) {
				$collection->getSelect()
					->join(array('link'=>'college_article_link'),
					'link.link_article=main_table.article_id');
			}
			$this->_collection = $collection;
		}
		return $this->_collection;
	}
}

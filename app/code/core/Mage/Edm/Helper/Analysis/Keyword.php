<?php
/***
 * 调用Sphinx搜索引擎
 */

class Mage_Edm_Helper_Analysis_Keyword extends Mage_Core_Helper_Abstract
{
	protected $_stemmer;
	protected $_sphinx;
	protected $_defaultIndex = 'idx_client'; //索引名称
	
	public function getWriteConnect()
	{
		$coreResource = Mage::getSingleton('core/resource');
		$conn = $coreResource->getConnection('core_write');
		return $conn;
	}
	
	protected function _init() {
		$this->_stemmer = Mage::helper('edm/stemmer');
		$this->_sphinx = Mage::helper('edm/sphinx');
	}
	
	/***
	 * 分页取
	 */
	public function getClientsByKeyword($keyword,$operator=false,$curpage=1,$pagesize=20) {
		$this->_init();
		$sphinxHelper = $this->_sphinx;
		if ($operator) {
			$sphinxHelper->setMatchMode($operator);
		}
		$result = $sphinxHelper->query($keyword,$this->_defaultIndex);
		//echo "<xmp>";var_dump($result);echo "</xmp>";die();
		if (count($result['matches'])) { //条件后面跟动作
			$totalFound = $result['total_found'];
			$total = $result['total'];
			$idArr = array();
			foreach ($result['matches'] as $k => $v) {
				array_push($idArr,$k);
			}
			$collection = Mage::getResourceModel('edm/client_collection')
				->addFieldToFilter('client_id',array('in'=>$idArr));
			return array(
				'total' => $totalFound,
				'items' => $collection,
				'curpage' => $curpage,
				'pagesize' => $pagesize,
			);
		} else {
			return false;
		}
	}
}
?>

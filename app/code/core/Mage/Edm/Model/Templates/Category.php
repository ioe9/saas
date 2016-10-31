<?php
class Mage_Edm_Model_Templates_Category extends Mage_Core_Model_Abstract
{
	protected $_categoriesOptions = null;

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/templates_category');
    }
    
    
	public function getCategoriesOption($excludeId = false)
	{
		if (is_null($this->_categoriesOptions)) {
			$this->_categoriesOptions[''] = ('-- 请选择 --');

			$collection = $this->getCollection(); 
			$arr = array();
			$levelArray1 = array();
			$levelArray2 = array();
			$levelArray3 = array();
			$levelArray4 = array();
			if ($collection->count()){ 
				foreach ($collection as $cat){ 
					if ($excludeId) {
						if ($cat->getId()==$excludeId) {
							continue;
						}
					}
					
					if ($cat->getLevel()==0) {
						array_push($levelArray1,$cat);
					}
					if ($cat->getLevel()==1) {
						array_push($levelArray2,$cat);
					}
					if ($cat->getLevel()==2) {
						array_push($levelArray3,$cat);
					}
					if ($cat->getLevel()==3) {
						array_push($levelArray4,$cat);
					}
				} 
			}
			if (count($levelArray1)) {
				foreach ($levelArray1 as $_level1) {
					$this->_categoriesOptions[$_level1->getId()] = $_level1->getCategoryName();
					if (count($levelArray2)) {
						foreach ($levelArray2 as $_level2) {
							if ($_level2->getParentId()==$_level1->getId()) {
								$this->_categoriesOptions[$_level2->getId()] = '=='.$_level2->getCategoryName().'   ('.$_level2->getId().')';
								if (count($levelArray3)) {
									foreach ($levelArray3 as $_level3) {
										if ($_level3->getParentId()==$_level2->getId()) {
											$this->_categoriesOptions[$_level3->getId()] = '----'.$_level3->getCategoryName().'   ('.$_level3->getId().')';
											if (count($levelArray4)){
												foreach ($levelArray4 as $_level4) {
													if ($_level4->getParentId()==$_level3->getId()) {
														$this->_categoriesOptions[$_level4->getId()] = '******'.$_level4->getCategoryName().'   ('.$_level4->getId().')';
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		
		return $this->_categoriesOptions;
	}
}

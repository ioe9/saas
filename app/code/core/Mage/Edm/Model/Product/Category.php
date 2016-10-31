<?php
class Mage_Edm_Model_Product_Category extends Mage_Core_Model_Abstract
{
	protected $_categoriesOptions = null;

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('edm/product_category');
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
					$this->_categoriesOptions[$_level1->getId()] = $_level1->getName();
					if (count($levelArray2)) {
						foreach ($levelArray2 as $_level2) {
							if ($_level2->getParentId()==$_level1->getId()) {
								$this->_categoriesOptions[$_level2->getId()] = '=='.$_level2->getName().'   ('.$_level2->getId().')';
								if (count($levelArray3)) {
									foreach ($levelArray3 as $_level3) {
										if ($_level3->getParentId()==$_level2->getId()) {
											$this->_categoriesOptions[$_level3->getId()] = '----'.$_level3->getName().'   ('.$_level3->getId().')';
											if (count($levelArray4)){
												foreach ($levelArray4 as $_level4) {
													if ($_level4->getParentId()==$_level3->getId()) {
														$this->_categoriesOptions[$_level4->getId()] = '******'.$_level4->getName().'   ('.$_level4->getId().')';
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
	
	public function getCategoriesMulitiOption($maxLevel=10,$optionGroup=false)
	{
		if (is_null($this->_categoriesOptions)) {
			$this->_categoriesOptions[''] = array('value'=>'','label'=>'-- 请选择 --');

			$collection = $this->getCollection()->addFieldToFilter('status',1); 
			$arr = array();
			$levelArray1 = array();
			$levelArray2 = array();
			$levelArray3 = array();
			$levelArray4 = array();
			if ($collection->count()){ 
				foreach ($collection as $cat){ 
					if ($cat->getLevel()==0) {
						array_push($levelArray1,$cat);
					}
					if ($cat->getLevel()==1) {
						array_push($levelArray2,$cat);
					}
					if ($maxLevel>=2) {
						if ($cat->getLevel()==2) {
							array_push($levelArray3,$cat);
						}
					}
					if ($maxLevel>=3) {
						if ($cat->getLevel()==3) {
							array_push($levelArray4,$cat);
						}
					}
					
				} 
			}
			if (count($levelArray1)) {
				foreach ($levelArray1 as $_level1) {
					if (!$optionGroup) {
						$this->_categoriesOptions[$_level1->getId()] = array('value'=>$_level1->getId(),'label'=>$_level1->getName());
						if (count($levelArray2)) {
							foreach ($levelArray2 as $_level2) {
								if ($_level2->getParentId()==$_level1->getId()) {
									$this->_categoriesOptions[$_level2->getId()] = array('value'=>$_level2->getId(),'label'=>'--'.$_level2->getName().'   ('.$_level2->getId().')');
									if ($maxLevel>=2) {
										if (count($levelArray3)) {
											foreach ($levelArray3 as $_level3) {
												if ($_level3->getParentId()==$_level2->getId()) {
													$this->_categoriesOptions[$_level3->getId()] = array('value'=>$_level3->getId(),'label'=>'----'.$_level3->getName().'   ('.$_level3->getId().')');
													/*
													if (count($levelArray4)){
														foreach ($levelArray4 as $_level4) {
															if ($_level4->getParentId()==$_level3->getId()) {
																$this->_categoriesOptions[$_level4->getId()] = '------'.$_level4->getName().'   ('.$_level4->getId().')';
															}
														}
													}*/
												}
											}
										}
									}
								}
							}
						}
					} else {

						$group = array();
						//$values[$_level1->getId()] = array('value'=>$_level1->getId(),'label'=>$_level1->getName());
						$values = array();
						if (count($levelArray2)) {
							foreach ($levelArray2 as $_level2) {
								if ($_level2->getParentId()==$_level1->getId()) {
									$values[$_level2->getId()] = array('value'=>$_level2->getId(),'label'=>''.$_level2->getName().'   ('.$_level2->getId().')');;
									if ($maxLevel>=2) {
										if (count($levelArray3)) {
											foreach ($levelArray3 as $_level3) {
												if ($_level3->getParentId()==$_level2->getId()) {
													$values[$_level3->getId()] = array('value'=>$_level3->getId(),'label'=>'----'.$_level3->getName().'   ('.$_level3->getId().')');
													/*
													if (count($levelArray4)){
														foreach ($levelArray4 as $_level4) {
															if ($_level4->getParentId()==$_level3->getId()) {
																$values[$_level4->getId()] = '------'.$_level4->getName().'   ('.$_level4->getId().')';
															}
														}
													}*/
												}
											}
										}
									}
								}
							}
						}
						$this->_categoriesOptions[] = array('label'=>$_level1->getName(),'value'=>$values);
						//echo "<xmp>";var_dump($this->_categoriesOptions); echo "</xmp>";
					}
						
				}
			}
		}
		
		return $this->_categoriesOptions;
	}
	
	public function getSecondMulitiOption()
	{
		if (is_null($this->_categoriesOptions)) {
			$this->_categoriesOptions[''] = array('value'=>'','label'=>'-- 请选择 --');

			$collection = $this->getCollection()->addFieldToFilter('status',1); 
			$arr = array();
			$levelArray1 = array();
			$levelArray2 = array();
			$levelArray3 = array();
			$levelArray4 = array();
			if ($collection->count()){ 
				foreach ($collection as $cat){ 
					if ($cat->getLevel()==0) {
						array_push($levelArray1,$cat);
					}
					if ($cat->getLevel()==1) {
						array_push($levelArray2,$cat);
					}
					
					if ($cat->getLevel()==2) {
						array_push($levelArray3,$cat);
					}
				} 
			}
			if (count($levelArray1)) {
				foreach ($levelArray1 as $_level1) {
					$group = array();
					
					
					if (count($levelArray2)) {
						foreach ($levelArray2 as $_level2) {
							if ($_level2->getParentId()==$_level1->getId()) {
								$values = array();
								//$values[$_level2->getId()] = array('value'=>$_level2->getId(),'label'=>''.$_level2->getName().'   ('.$_level2->getId().')');;
								if (count($levelArray3)) {
									foreach ($levelArray3 as $_level3) {
										if ($_level3->getParentId()==$_level2->getId()) {
											$values[$_level3->getId()] = array('value'=>$_level3->getId(),'label'=>'----'.$_level3->getName().'   ('.$_level3->getId().')');
											
										}
									}
								}
								$this->_categoriesOptions[] = array('label'=>$_level1->getName(),'value'=>$values);

							}
						}
					}
					
				}
			}
		}
		
		return $this->_categoriesOptions;
	}
	
	public function collectRuleVariable() {
		$collection = $this->getCollection()
			->addFieldToFilter('level',array('in'=>array(2)));
		$arr = array();
		foreach ($collection as $_c) {
			array_push($arr,$_c->getName());
		}
		return implode(';',$arr);
	}
	
	public function getChildren() {
		$collection = $this->getCollection()
			->addFieldToFilter('parent_id',$this->getId())
			->addFieldToFilter('status',1);
		return $collection;
	}
}

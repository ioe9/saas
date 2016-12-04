<?php
/***
 * 开发信，系统自带模板
 */
class Mage_Edm_Helper_Scene_Develop extends Mage_Core_Helper_Abstract
{
	protected $_content = array();
	protected $_modules = array();
	protected $_moduleConfig = array();
	protected $_previewCompany = array();
	protected $_previewClient = array();
	protected $_previewCompanyAdvantage = array();
	protected $_previewCompanyAdvantageCopy = array();
	protected $_previewContact = array();
	
	//模块标识符
	const PATTERN_MODULE = '/\[\[(.*?)\]\]/si';
	
	//会员属性标识符
	const PATTERN_COMPANY_ATTR = '/{%(.*?)%}/si';
	
	//会员优势标识符
	const PATTERN_COMPANY_ADV = '/{\[(.*?)\]}/si';
	
	//客户属性
	const PATTERN_CLIENT_ATTR = '/\[%(.*?)%\]/si';
	
	//联系人属性标识符
	const PATTERN_CUSTOMFIELD = '/%%(.*?)%%/si';
	
	//同义词替换 
	const PATTERN_SYN = '/\[{(.*?)}\]/si';
	
	//Widget
	const PATTERN_WIDGET = '/{{([a-z]{0,10})(.*?)}}/si';
	
	protected function _initPreview() {
		$template = Mage::registry('current_template');
		$collection = Mage::getResourceModel('edm/template_module_collection');
		$collection->getSelect()
			->join(array('link'=>'edm_template_module_link'),'main_table.module_id=link.link_module',array('link_id'));
		$collection->addFieldToFilter('link_template',$template->getId());
		$arr = array();
		$content = array();
		foreach ($collection as $_c) {
			$arr[trim($_c->getModuleName())] = array('info'=>$_c,'module_id'=>$_c->getId(),'link_id'=>$_c->getData('link_id'));
			array_push($content,'[['.trim($_c->getModuleName()).']]');
		}
		$this->_content = implode('',$content);
		$this->_modules = $arr;
		$this->_previewClient = $this->getPreviewClient();
		$this->_previewCompany = $this->getPreviewCompany();
		$this->_previewCompanyAdvantage = $this->getPreviewCompanyAdvantage();
		$this->_previewContact = $this->getPreviewContact();
	}
	/***
	 * 渲染模版主函数
	 * $content String
	 * return String
	 */
	public function render($moduleName=false,$moduleConfig=false,$templateId=false,$itemNum=1) {
		
		$this->_initPreview();
		$content = $this->_content;
		if ($moduleName) {
			if ($moduleConfig) {
				if ($moduleName=='邮件标题') {
					
					$this->processModule('[[邮件标题]]',true,$moduleName,$moduleConfig,$templateId,$itemNum);
				} else {
					$this->processModule($content,true,$moduleName,$moduleConfig,$templateId,$itemNum);
				}
				return $this->_moduleConfig;
			} else {
			
				if ($moduleName=='邮件标题') {
					$output = $this->processModule('[[邮件标题]]');
					
				} else {
					$output = $this->processModule('[['.$moduleName.']]',true,$moduleName);
				}
				return 	$output;
			}
				
		} else {
			$title = $this->processModule('[[邮件标题]]');
			//var_dump($content);die();
			$output = $this->processModule($content,true,$moduleName);
			return 	array('title'=>strip_tags($title),'content'=>$output);
		}
		
	}
	
	/***
	 * 处理模块变量
	 * 只有模块能包含其他变量
	 * $value 待处理字符串 
	 * $decor 是否对替换内容高亮
	 */
	public function processModule($value,$decor=true,$moduleName=false,$moduleConfig=true,$templateId=false,$itemNum=1){
		$company = Mage::registry('current_company');
		$modules = &$this->_modules;
		//模块外套一个DIV
    	if(preg_match_all(self::PATTERN_MODULE, $value, $constructions, PREG_SET_ORDER)) {
    		
    		$construction[1] = trim($construction[1]);
    		$i = 0;
    		foreach($constructions as $index=>$construction) {
    			if ($moduleName) {
    				if (!strstr($construction[0],$moduleName)) {
	    				
	    				//直接删除
	    				continue;
	    			}
    			}
    			if (!$moduleName) {
    				$i++;
	    			$uid = uniqid().$i;
	    			$value = str_replace($construction[0],"<div class='module_handle' data-name='".str_replace(array('[',']'),'',$construction[0])."' id='module_handle_".$uid."'>".$construction[0].'</div>',$value);
    			}
	    			
    		}
    	}
    	if(preg_match_all(self::PATTERN_MODULE, $value, $constructions, PREG_SET_ORDER)) {
    		$construction[1] = trim($construction[1]);
    		
    		foreach($constructions as $index=>$construction) {
    			if ($moduleName) {
    				//echo $construction[0].'='.$moduleName;
	    			if (!strstr($construction[0],$moduleName)) {
	    				//直接删除
	    				continue;
	    			}
	    		}
	    		
                 // $construction = { [0]=> string(16) "[[邮件标题]]" [1]=> string(12) "邮件标题" }
                 
                 if ($construction[0]=="[[公司优势]]") {
					//默认优势全展示出来，而且要分组，但是说法是随机的 PATTERN_COMPANY_ADV
					//获取客户触动点，取前两个
					$clientTouchPoints = $this->getClientTouchPoint();
					
					
					$advIds = array();
					$selectedAdsIds1 = array();
					$selectedAdsIds2 = array();
					foreach ($this->_previewCompanyAdvantage as $_kk => $_vv) {
						array_push($advIds,$_vv['advantage_id']);
					}
					
					$advRel1 = Mage::getResourceModel('edm/company_advantage_attrvalue_collection')
						->addFieldToFilter('attr_id',2)

						->addFieldToFilter('advantage_id',array('in'=>$advIds))
						->addFieldToFilter('value',$clientTouchPoints[0]);
					
					foreach ($advRel1 as $_v) {
						array_push($selectedAdsIds1,$_v->getData('advantage_id'));
					}
					$advRel2 = Mage::getResourceModel('edm/company_advantage_attrvalue_collection')
						->addFieldToFilter('attr_id',2)
						
						->addFieldToFilter('advantage_id',array('in'=>$advIds))
						->addFieldToFilter('value',$clientTouchPoints[1]);
					foreach ($advRel2 as $_v) {
						if (!in_array($_v->getData('advantage_id'),$selectedAdsIds1)) {
							array_push($selectedAdsIds2,$_v->getData('advantage_id'));
						}
						
					}
					$tmpAdvRel1 = array();
					$tmpAdvRel2 = array();
					$advRel1 = Mage::getResourceModel('edm/company_advantage_value_collection')
						->addFieldToFilter('advantage_id',array('in'=>$selectedAdsIds1))
						->addFieldToFilter('company_id',$company->getId());
					
					$advRel2 = Mage::getResourceModel('edm/company_advantage_value_collection')
						->addFieldToFilter('advantage_id',array('in'=>$selectedAdsIds2))
						->addFieldToFilter('company_id',$company->getId());
					
					foreach ($advRel1 as $_t) {
						if (!array_key_exists($_t->getData('advantage_id'),$tmpAdvRel1)) {
							$tmpAdvRel1[$_t->getData('advantage_id')] = array($_t);
						} else {
							$tmpAdvRel1[$_t->getData('advantage_id')][] = $_t;
						}
					}
					//var_dump(count($advRel1));
					//var_dump(count($tmpAdvRel1));
					foreach ($advRel2 as $_t) {
						if (!array_key_exists($_t->getData('advantage_id'),$tmpAdvRel2)) {
							$tmpAdvRel2[$_t->getData('advantage_id')] = array($_t);
						} else {
							$tmpAdvRel2[$_t->getData('advantage_id')][] = $_t;
						}
					}
					shuffle($tmpAdvRel1);
					shuffle($tmpAdvRel2);
					//模块配置，优势可以设置和数量可设置
					$advAllArr = array();
        			if ($moduleName && $moduleConfig && $templateId) {
        				if ($itemNum<3) {
        					$itemNum = 3;
        				}
						$tmpAdvRel1 = array_slice($tmpAdvRel1,0,$itemNum);	
						$tmpAdvRel2 = array_slice($tmpAdvRel2,0,$itemNum);	
						
        			} else {
        				$tmpAdvRel1 = array_slice($tmpAdvRel1,0,3);	
						$tmpAdvRel2 = array_slice($tmpAdvRel2,0,3);
        			}
        			array_push($advAllArr,$tmpAdvRel1,$tmpAdvRel2);
        			
					//取其中三个
					foreach ($advAllArr as  $tmpAdvRel) {
						foreach ($tmpAdvRel as $_k=>$_v) {
							if (count($_v)) {
	        					$_v = $_v[array_rand($_v)];
	        					//判断类型
	        					$advantage = Mage::getModel('edm/company_advantage')->load($_v->getData('advantage_id'));
	        					$type = $advantage->getData('advantage_type')=='text';
	        					$allContent = $advantage->getData('advantage_type')=='text';
	        					if (!$_v->getData('value')) {
	        						continue;
	        					}
	        					if ($type=='text') {
	        						if ($allContent==1) {
	        							$optionalContent = $_v->getData('value');
	        							$optionalContent = $this->processCompanyAttr($optionalContent,$decor);
					        			$optionalContent = $this->processClientAttr($optionalContent,$decor);
					        			$optionalContent = $this->processContactAttr($optionalContent,$decor);
					        			$optionalContent = $this->processCompanyAdvantage($optionalContent,$decor);
	        							if ($moduleName && $moduleConfig && $templateId) {
	        								//array_push($this->_moduleConfig,$optionalContent);
	        								$this->_moduleConfig[$advantage->getId()] = $optionalContent;
	        							} else {
	        								
		        							$value = str_replace($construction[0],$construction[0].'<li>'.$optionalContent."</li>",$value);
	        							}
		        							
	        						}
	        					} else if ($type=='boolean') {
	        						if ($_v->getData('value')) {
	        							$optionalContent = explode("\n",$_v->getData('optional_content'));
	        							$optionalContent = $optionalContent[array_rand($optionalContent)];
	        							
	        							$optionalContent = $this->processCompanyAttr($optionalContent,$decor);
					        			$optionalContent = $this->processClientAttr($optionalContent,$decor);
					        			$optionalContent = $this->processContactAttr($optionalContent,$decor);
					        			$optionalContent = $this->processCompanyAdvantage($optionalContent,$decor);
	        							if ($moduleName && $moduleConfig && $templateId) {
	        								//array_push($this->_moduleConfig,$optionalContent);
	        								$this->_moduleConfig[$advantage->getId()] = $optionalContent;
	        							} else {
	        								$value = str_replace($construction[0],$construction[0].'<li>'.$optionalContent."</li>",$value);
	        							}
	        						}
	        					}
	        					
							}
							
						}
					}   			
					$value = str_replace($construction[0],'',$value);
					
				}
				
				//称呼 特殊处理
				if ($construction[0]=="[[称呼]]") {
					
					$tmp = array();
					$items = Mage::getResourceModel('edm/template_module_item_collection')
            			->addFieldToFilter('item_status',1)
            			->addFieldToFilter('item_link',$this->_modules['称呼']['link_id']);
        			foreach ($items as $_item) {
        				if (array_key_exists('联系人',$this->_previewClient) && $this->_previewClient['联系人']) {
	        				if (!strstr($_item->getData('item_content'),'联系人')) {
	        					continue;
	        				}
	        				array_push($tmp,$_item->getData('item_content'));
        				} else {
        					if (strstr($_item->getData('item_content'),'联系人')) {
	        					continue;
	        				}
	        				array_push($tmp,$_item->getData('item_content'));
        				}
        				if ($moduleName && $moduleConfig && $templateId) {
        					$this->_moduleConfig[$_item->getId()] = $_item->getData('item_content');
        				}
        				
        			}
        			//模块配置，称呼
        			if ($moduleName && $moduleConfig && $templateId) {
        				
        			} else {
        				$randomItem = $tmp[array_rand($tmp)];
						
						if (array_key_exists('联系人',$this->_previewClient) && $this->_previewClient['联系人']) {
							$randomItem = $this->processClientAttr($randomItem,$decor);
						}
						$value = str_replace($construction[0],$randomItem,$value);
        			}
                } else {
                	if ($construction[1] && array_key_exists($construction[1],$modules)) {
	                	if (array_key_exists('items',$modules[$construction[1]])) {
	                		//随机替换
	                	} else {
	                		//先加载再替换
	                		$items = Mage::getResourceModel('edm/template_module_item_collection')
	                			->addFieldToFilter('item_status',1)
	                			->addFieldToFilter('item_link',$modules[$construction[1]]['link_id']);
                			
	            			$arr = array();
	            			if (count($items)) {
	            				foreach ($items as $_item) {
	            					if ($itemParent = $_item->getData('item_parent')) {
	            						$relates = Mage::getResourceModel('edm/template_module_item_relate_collection')->addFieldToFilter('item_id',$itemParent);
	            					} else {
	            						$relates = Mage::getResourceModel('edm/company_template_module_item_relate_collection')->addFieldToFilter('item_id',$_item->getId());
	            					}
	            					//这里处理依赖关系  !!!!这里要修改，关联关系是公司自己的模块项变量 （跟系统走？？？还是跟公司自己的模版走）
	            					
	            					$flag = true;
	            					foreach ($relates as $_r) {
	            						$name = $_r->getData('name');
	            						if ($_r->getData('type')=='client_attr') { //客户信息，判断当前客户是否有该属性
	            							//echo "<xmp>";var_dump($this->_previewClient);echo "</xmp>";
	            							if (!$this->_previewClient[$name]) {
	            								$flag = false;
	            								continue;
	            							}
	            						} else if ($_r->getData('type')=='company_attr') { //会员信息，判断当前会员是否有该属性
	            							//echo "<xmp>";var_dump($this->_previewCompany[$name]);echo "</xmp>";
	            							if (!$this->_previewCompany[$name]) {
	            								$flag = false;
	            								continue;
	            							}
	            						}  else if ($_r->getData('type')=='company_advantage') { //公司优势，判断当前公司是否有该优势
	            							//echo "<xmp>";var_dump($this->_previewCompany[$name]);echo "</xmp>";
	            							
	            							if (!$this->_previewCompanyAdvantageCopy[$name]) {
	            								$flag = false;
	            								continue;
	            							}
	            						} else if ($_r->getData('type')=='contact_attr') { //联系人信息，判断当前联系人是否有该属性
	            							//echo "<xmp>";var_dump($this->_previewContact[$name]);echo "</xmp>";
	            							if (!$this->_previewContact[$name]) {
	            								$flag = false;
	            								continue;
	            							}
	            						}
	            					}
	            					
	            					
	            					//这里处理项-客户属性关联关系
	            					if ($itemParent) {
	            						$attrRelates = Mage::getResourceModel('edm/template_module_item_attrvalue_collection')->addFieldToFilter('item_id',$itemParent);
	            					} else {
	            						$attrRelates = Mage::getResourceModel('edm/template_module_item_attrvalue_collection')->addFieldToFilter('item_id',$_item->getId());
	            					}
	            					
	            					$attrRelates->getSelect()->join(array('attr'=>'edm_client_attr'),'attr.attr_id=main_table.attr_id',array('name'));
	            					$attrRelateValues = array();
	            					foreach ($attrRelates as $_r) {
	            						if ($_r->getValue) {
	            							if (!array_key_exists($_r->getName())) {
		            							$attrRelateValues[$_r->getName()] = array($_r->getValue);
		            						} else {
		            							array_push($attrRelateValues[$_r->getName()],$_r->getValue);
		            						}
	            						}	
	            					}
	            					foreach ($attrRelateValues as $_k=>$_v) {
	            						$cValues = $this->_previewClient[$_k];
	            						//取交集
	            						$cIntersect = array_intersect($cValues,$_v);
	            						//属性没有交集
	            						if (!count($cIntersect)) {
	            							$flag = false;
	            							continue;
	            						}
	            					}
	            					
	            					
	            					if (!$flag) {
	            						continue;
	            					}
		            				array_push($arr,$_item);
		            			}
		            			//echo "<xmp>";var_dump($arr); echo "</xmp>";
		            			//die();
		            			if (count($arr)) {
		            				$modules[$construction[1]]['items'] = $arr;
		            				//随机取一项，除了公司优势是特殊情况
		            				
		            				
	            					if (count($arr)) {
		            					
		            					//模块配置
				            			if ($moduleName && $moduleConfig && $templateId) {
				            				foreach ($arr as $randomItem) {
				            					$itemContent = $randomItem->getItemContent();
						            			//这里做变量替换
						            			$itemContent = $this->processCompanyAttr($itemContent,$decor);
						            			$itemContent = $this->processClientAttr($itemContent,$decor);
						            			$itemContent = $this->processContactAttr($itemContent,$decor);
						            			$itemContent = $this->processCompanyAdvantage($itemContent,$decor);
						            			
						            			//array_push($this->_moduleConfig,$itemContent);
						            			$this->_moduleConfig[$randomItem->getId()] = $itemContent;
						            			//$value = str_replace($construction[0],$itemContent,$value);
				            				}
				            			} else {
				            				$randomItem = $arr[array_rand($arr)];
					            			$itemContent = $randomItem->getItemContent();
					            			//这里做变量替换
					            			$itemContent = $this->processCompanyAttr($itemContent,$decor);
					            			$itemContent = $this->processClientAttr($itemContent,$decor);
					            			$itemContent = $this->processContactAttr($itemContent,$decor);
					            			$itemContent = $this->processCompanyAdvantage($itemContent,$decor);
					            			
					            			$value = str_replace($construction[0],$itemContent,$value);
				            			}
				            			
		            				}
		            				
			            				
				            			
		            			}
			            			
	            			} else {
	            				$value = str_replace($construction[0],'',$value);
	            			}
		            			
	                	}
	                }
                }
	                 
            }
    	}
    	//把无效的模块剔除
    	if(preg_match_all(self::PATTERN_MODULE, $value, $constructions, PREG_SET_ORDER)) {
    		
    		$construction[1] = trim($construction[1]);
    		foreach($constructions as $index=>$construction) {
    			$value = str_replace($construction[0],'',$value);
    		}
    	}
    	return $value;
    	
    	
    }
    public function getAdvantageCodeById($id) {
    	foreach ($this->_previewCompanyAdvantage as $_kk => $_vv) {
    		if ($_vv['advantage_id']==$id) {
    			return $_kk;
    		}
    	}
    	return false;
    }
    /***
     * 获取客户触痛点
     */
    public function getClientTouchPoint()
    {
    	$client = Mage::registry('current_client');
    	if ($client) {
    		$quality=$client->getData('index_quality');
			$price = $client->getData('index_price');
			$design = $client->getData('index_design');
			$service = $client->getData('index_service');
    	} else {
    		$quality = '80';
			$price = '80';
			$design = '80';
			$service = '80';
    	}
    	
		
		$indexArr = array($quality,$price,$design,$service);
		$maxPos = array_search(max($indexArr), $indexArr);
		unset($indexArr[$maxPos]);
		$secondMaxPos = array_search(max($indexArr), $indexArr);
		$strArr = array('Quality','Price','Design','Service');
		$strArr2 = $strArr;
		unset($strArr2[$maxPos]);
		return array($strArr[$maxPos],$strArr2[$secondMaxPos]);
    }
    /***
     * 处理会员属性
     */
    public function processCompanyAttr($value,$decor=true) {
    	if(preg_match_all(self::PATTERN_COMPANY_ATTR, $value, $constructions, PREG_SET_ORDER)) {
    		$construction[1] = trim($construction[1]);
    		foreach($constructions as $index=>$construction) {
                // $construction = { [0]=> string(16) "{%产品关键词%}" [1]=> string(12) "产品关键词" }
                if ($construction[1] && array_key_exists($construction[1],$this->_previewCompany)) {
                	if ($decor) {
                		$value = str_replace($construction[0],'<label class="edm_decor">'.$this->_previewCompany[$construction[1]].'</label>',$value);
                	} else {
                		$value = str_replace($construction[0],$this->_previewCompany[$construction[1]],$value);
                	}
        			
                } else {
                	
                }
            }
    	}
    	return $value;
    }
    
    /***
     * 处理公司优势
     */
    public function processCompanyAdvantage($value,$decor=true) {
    	if(preg_match_all(self::PATTERN_COMPANY_ADV, $value, $constructions, PREG_SET_ORDER)) {
    		$construction[1] = trim($construction[1]);
    		
    		foreach($constructions as $index=>$construction) {
                // $construction = { [0]=> string(16) "{%产品关键词%}" [1]=> string(12) "产品关键词" }
               
                if ($construction[1] && array_key_exists($construction[1],$this->_previewCompanyAdvantageCopy)) {
                	//随机取一个
                	$tmp = $this->_previewCompanyAdvantageCopy[$construction[1]];
                	//var_dump($tmp);
                	$advValue = $tmp[array_rand($tmp)];
                	if ($advValue && $advValue['value']) {
                		if ($decor) {
	                		$value = str_replace($construction[0],'<label class="edm_decor">'.$advValue['value'].'</label>',$value);
	                	} else {
	                		$value = str_replace($construction[0],$advValue['value'],$value);
	                	}
                	}
	                	
        			
                } else {
                	
                }
            }
    	}
    	return $value;
    }
    
    /**
     * 处理联系人属性
     */
    public function processCustomfield($value,$decor=true) {
    	if(preg_match_all(self::PATTERN_CUSTOMFIELD, $value, $constructions, PREG_SET_ORDER)) {
    		$construction[1] = trim($construction[1]);
    		foreach($constructions as $index=>$construction) {
                if ($construction[1] && array_key_exists($construction[1],$this->_previewCompany)) {
                	if ($decor) {
                		$value = str_replace($construction[0],'<label class="edm_decor">'.$this->_previewCompany[$construction[1]].'</label>',$value);
                	} else {
                		$value = str_replace($construction[0],$this->_previewCompany[$construction[1]],$value);
                	}
        			
                } else {
                }
            }
    	}
    	
    }
    
    /***
     * 处理客户属性
     */
    public function processClientAttr($value,$decor=true) {
    	if(preg_match_all(self::PATTERN_CLIENT_ATTR, $value, $constructions, PREG_SET_ORDER)) {
    		$construction[1] = trim($construction[1]);
    		foreach($constructions as $index=>$construction) {
                if ($construction[1] && array_key_exists($construction[1],$this->_previewClient)) {
                	if ($decor) {
                		$value = str_replace($construction[0],'<label class="edm_decor" >'.ucwords($this->_previewClient[$construction[1]]).'</label>',$value);
                	} else {
                		$value = str_replace($construction[0],ucwords($this->_previewClient[$construction[1]]),$value);
                	}
        			
                } else {
                	
                }
            }
    	}
    	return $value;
    }
    /***
     * 处理联系人属性
     */
    public function processContactAttr($value,$decor=true) {
    	if(preg_match_all(self::PATTERN_CUSTOMFIELD, $value, $constructions, PREG_SET_ORDER)) {
    		$construction[1] = trim($construction[1]);
    		foreach($constructions as $index=>$construction) {
                if ($construction[1] && array_key_exists($construction[1],$this->_previewContact)) {
                	if ($decor) {
                		$value = str_replace($construction[0],'<label>'.$this->_previewContact[$construction[1]].'</label>',$value);
                	} else {
                		$value = str_replace($construction[0],$this->_previewContact[$construction[1]],$value);
                	}
        			
                } else {
                	
                }
            }
    	}
    	return $value;
    }
    
    /***
     * 读取公司信息
     */
    public function getPreviewCompany() {
    	$company = Mage::registry('current_company');
    	$companyAttrData = array();
    	//这里根据字段处理基本属性，根据变量处理自定义属性
    	$values = Mage::getResourceModel('edm/company_attr_value_collection')
					->addFieldToFilter('company_id',$company->getId());
		$values->getSelect()
			->join(array('attr'=>'edm_company_attr'),'attr.attr_id=main_table.attr_id',array('name'));
		foreach ($values as $_value) {
			$companyAttrData[$_value->getName()] = $_value->getValue();
		}
		$data = $company->getData();
		$companyData = array();
		$companyData['公司名称'] = $data['name'];
		$companyData['联系人'] = $data['contact_person'];
		$companyData['联系邮箱'] = $data['contact_email'];
		
		$companyData['公司地址'] = $data['street'] .' ' .$data['province'].' ' .$data['city']. ' ' . $data['country'];
		$companyData['公司官网'] = $data['website'];
		//推广产品，产品关键词做特殊处理
		$promoProduct = Mage::registry('product_promo') ? Mage::registry('product_promo') : '';
		if ($promoProduct) {
			$companyData['推广产品'] = $promoProduct;
		}
		$companyAttrData['产品范围'] = implode(',',Mage::helper('edm/front_company')->getSubCategoriesNames($company));
    	return array_merge($companyData,$companyAttrData);
    }
    
    
    public function getPreviewCompanyAdvantage() {
    	$company = Mage::registry('current_company');
    	if (!$company || !$company->getId()) {
    		$company = Mage::getModel('edm/company')->load(4);
    		//这里做特殊处理
    	}
    	
    	$companyAdvantageData = array();
    
    	$values = Mage::getResourceModel('edm/company_advantage_value_collection')
					->addFieldToFilter('company_id',$company->getId())
					//->addFieldToFilter('enable_scope',0)
					->addFieldToFilter('main_table.value',array('notnull'=>true));
		$values->getSelect()
			->join(array('adv'=>'edm_company_advantage'),'adv.advantage_id=main_table.advantage_id',array('code','enable_scope'));
		
		foreach ($values as $_value) {
			if ($_value->getData('enable_scope')==0) {
				$companyAdvantageData[$_value->getCode()] = array('value'=>$_value->getValue(),'advantage_id'=>$_value->getData('advantage_id'));
			} else {
				
				if (array_key_exists($_value->getCode(),$this->_previewCompanyAdvantageCopy)) {
					$this->_previewCompanyAdvantageCopy[$_value->getCode()] = array(array('value'=>$_value->getValue(),'advantage_id'=>$_value->getData('advantage_id')));
				} else {
					$this->_previewCompanyAdvantageCopy[$_value->getCode()][] = array('value'=>$_value->getValue(),'advantage_id'=>$_value->getData('advantage_id'));
				}
				
			}
			
		}
		
    	return $companyAdvantageData;
    }
    
    
    public function getPreviewClient() {
    	$client = Mage::registry('current_client');
    	if (!$client || !$client->getId()) {
    		$client = Mage::getModel('edm/client')->load(6);
    	}
    	$clientAttrData = array();
    	$clientAttrData['客户产品'] = $client->getData('selected_product') ? $client->getData('selected_product') : '';
    	$clientAttrData['客户国家'] = $client->getData('country');
    	$clientAttrData['客户名称'] = $client->getData('name');
    	$clientAttrData['联系人'] = $client->getData('contact_person');
    	//这里根据字段处理基本属性，根据变量处理自定义属性
    	$values = Mage::getResourceModel('edm/client_attr_value_collection')
					->addFieldToFilter('client_id',$client->getId());
		$values->getSelect()
			->join(array('attr'=>'edm_client_attr'),'attr.attr_id=main_table.attr_id',array('name','attr_type'));
		$_optionsValues = array();
		$_options = Mage::getResourceModel('edm/client_attr_option_collection');
		
		foreach ($values as $_value) {
			if ($_value->getAttrType() == 'multiselect') {
				
				$_option = Mage::getModel('edm/client_attr_option')
					->load($_value->getValue());
				if ($_option->getId()) {
					$_optionValue= $_option->getData('value');
					if (!array_key_exists($_value->getName(),$clientAttrData)) {
						$clientAttrData[$_value->getName()] = array($_optionValue);
					} else {
						array_push($clientAttrData[$_value->getName()] ,$_optionValue);
					}
				}
					
				
			} else {
				$clientAttrData[$_value->getName()] = $_value->getValue();
			}
			
		}
		$data = $client->getData();
		$clientData = array();
		
    	return array_merge($clientData, $clientAttrData);
    }
    
    public function getPreviewContact() {
    	$contact = Mage::registry('current_contact');
    	if (!$contact || !$contact->getId()) {
    		$contact = Mage::getModel('edm/client_email')->load(1);
    	}
    	$contactAttrData = array();
    	//这里根据字段处理基本属性，根据变量处理自定义属性
    	$values = Mage::getResourceModel('edm/client_email_attr_value_collection')
					->addFieldToFilter('email_id',$contact->getId());
		$values->getSelect()
			->join(array('attr'=>'edm_client_email_attr'),'attr.attr_id=main_table.attr_id',array('name','attr_type'));
		foreach ($values as $_value) {
			if ($_value->getAttrType() == 'multiselect') {
				if (!array_key_exists($_value->getName(),$contactAttrData)) {
					$contactAttrData[$_value->getName()] = array($_value->getValue());
				} else {
					array_push($contactAttrData[$_value->getName()] ,$_value->getValue());
				}
				
			} else {
				$contactAttrData[$_value->getName()] = $_value->getValue();
			}
			
		}
		$data = $contact->getData();
		$contactData = array();
    	return array_merge($contactData, $contactAttrData);
  
    }
    
    public function processVariableRelate($item) {
    	$value = $item->getItemContent();
    	$companyCollection = Mage::getResourceModel('edm/company_attr_collection');
    	$companyAdvantageCollection = Mage::getResourceModel('edm/company_advantage_collection');
    	$clientCollection = Mage::getResourceModel('edm/client_attr_collection');
    	$contactCollection = Mage::getResourceModel('edm/customfields_collection');
    	$companyValues = array();
    	$companyAdvantageValues = array();
    	$clientValues = array();
    	$contactValues = array(); 
    	foreach ($companyCollection as $_c) {
    		$companyValues[$_c->getName()] = $_c->getData();
    	}
    	foreach ($companyAdvantageCollection as $_c) {
    		$companyAdvantageValues[$_c->getCode()] = $_c->getData();
    	}
    	
    	foreach ($clientCollection as $_c) {
    		$clientValues[$_c->getName()] = $_c->getData();
    	}
    	foreach ($contactCollection as $_c) {
    		$contactValues[$_c->getName()] = $_c->getData();
    	}
    	//先删除关联
    	$this->deleteItemRelate($item->getId());
    	//会员属性
    	if(preg_match_all(self::PATTERN_COMPANY_ATTR, $value, $constructions, PREG_SET_ORDER)) {
    		$construction[1] = trim($construction[1]);
    		foreach($constructions as $index=>$construction) {
    			
    			if ($construction[1] && array_key_exists($construction[1],$companyValues)) {
    				 $this->createItemRelate('company_attr',$construction[1],$item->getId());
    			}
    		}
    	}
    	
    	//会员优势
    	if(preg_match_all(self::PATTERN_COMPANY_ADV, $value, $constructions, PREG_SET_ORDER)) {
    		$construction[1] = trim($construction[1]);
    		foreach($constructions as $index=>$construction) {
    			echo $construction[1];die();
    			if ($construction[1] && array_key_exists($construction[1],$companyAdvantageValues)) {
    				 $this->createItemRelate('company_advantage',$construction[1],$item->getId());
    			}
    		}
    	}
    	//联系人属性
    	if(preg_match_all(self::PATTERN_CUSTOMFIELD, $value, $constructions, PREG_SET_ORDER)) {
    		$construction[1] = trim($construction[1]);
    		foreach($constructions as $index=>$construction) {
    			if ($construction[1] && array_key_exists($construction[1],$contactValues)) {
    				$this->createItemRelate('contact_attr',$construction[1],$item->getId());
    			}
    		}
    	}
    	//客户属性
    	if(preg_match_all(self::PATTERN_CLIENT_ATTR, $value, $constructions, PREG_SET_ORDER)) {
    		$construction[1] = trim($construction[1]);
    		foreach($constructions as $index=>$construction) {
    			if ($construction[1] && array_key_exists($construction[1],$clientValues)) {
    				$this->createItemRelate('client_attr',$construction[1],$item->getId());
    			}
    		}
    	}
    	return true;
    }
    
    
    public function deleteItemRelate($itemId) {
    	if (Mage::registry('company_template_module_item')) {
    		$relates = Mage::getResourceModel('edm/company_template_module_item_relate_collection')
		 		->addFieldToFilter('item_id',$itemId);
    		
    	} else {
    		$relates = Mage::getResourceModel('edm/template_module_item_relate_collection')
		 		->addFieldToFilter('item_id',$itemId);
    	}
    	
	 	foreach ($relates as $_relate) {
	 		$_relate->delete();
	 	}
		return true;
    }
    public function createItemRelate($type,$name,$itemId) {
    	if (Mage::registry('company_template_module_item')) {
    		$model = Mage::getModel('edm/company_template_module_item_relate');
    	} else {
    		$model = Mage::getModel('edm/template_module_item_relate');
    	}
    	
	 	$model->setData('type',$type)
		 	->setData('name',$name)
		 	->setData('item_id',$itemId)
		 	->save();
	 	return $model;
    }
    
    
    /**
     * Layout也有依赖关系
     */
    public function renderLayout($design,$decor=false) {
    	$content = $design->getText();
		$this->_initPreview();
		$output = $this->processModule($content,$decor);
		$output = $this->processCompanyAttr($output,$decor);
		$output = $this->processClientAttr($output,$decor);
		$output = $this->processContactAttr($output,$decor);
		return $output;
    	
    }
    
    
    
}

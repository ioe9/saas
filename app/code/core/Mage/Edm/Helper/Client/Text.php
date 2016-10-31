<?php
/***
 * 解析规则，处理文本
 * 整合Sphinx搜索引擎
 * 条件要区分是否支持Sphinx,Sphinx的Stopwords是固定的
 */

class Mage_Edm_Helper_Client_Text extends Mage_Core_Helper_Abstract
{
	const PATTERN_RULE_VARIABLE = '/{{(.*?)}}/si';
	
	protected $_variables = array();
	protected $_nodes = array();
	protected $_maxLevel = 1;
	protected $_stemmer;
	protected $_sphinx;
	protected $_defaultIndex = 'test1'; //索引名称
	protected $_attr = array();
	protected $_client = false;
	protected $_clientTexts = false;
	protected $_clientTextMerge = false;
	public function getWriteConnect()
	{
		$coreResource = Mage::getSingleton('core/resource');
		$conn = $coreResource->getConnection('core_write');
		return $conn;
	}
	
	protected function _init($rule,$html=true,$client) {
		$this->_stemmer = Mage::helper('edm/stemmer');
		$this->_sphinx = Mage::helper('edm/sphinx');
		$this->_client = $client;
		$attr = Mage::getResourceModel('edm/client_attr_collection');
		foreach ($attr as $_v) {
			$options = array();
			if ($_v['attr_type']=='select' || $_v['attr_type']=='multiselect') {
				$attrOption = Mage::getResourceModel('edm/client_attr_option_collection')->addFieldToFilter('attr_id',$_v->getData('attr_id'));
				foreach ($attrOption as $_o) {
					$options[$_o->getValue()] = $_o->getId();
				}
			}
			$this->_attr[$_v->getData('name')] =array('id'=>$_v->getId(),'type'=>$_v['attr_type'],'options'=>$options);
		}
		$variables = Mage::getResourceModel('edm/client_rule_variable_collection');
		foreach ($variables as $_v) {
			$this->_variables[$_v->getData('name')] = trim($_v->getData('value'));
		}
		$str = $rule->getData('conditions');
		$arr = json_decode($str,true);
		if ($arr && is_array($arr)) {
			$nodes = $arr['data'];
			$this->_maxLevel = $arr['level'];
			$this->_nodes = $nodes;
		}
		
	}
	/***
	 * 解析规则主入口
	 * 
	 */
	public function process($rule,$html=true,$client=false) {
		$this->_init($rule,$html=true,$client);
		$this->_process();
	}
	
	/***
	 * 
	 */
	protected function _process($doLevel=1) {
		$maxLevel = $this->_maxLevel;
		
		$nodes = $this->_nodes;
		if ($doLevel<=$maxLevel) {
			foreach ($nodes as $_node) {
				//echo "<xmp>";var_dump($_node['level']); echo "</xmp>";
				if ($_node['level']==$doLevel) {
					if (array_key_exists('aggregator',$_node['combination'])) { //条件组合
						
						$aggregator = $_node['combination']['aggregator'];
						$value = $_node['combination']['value'];
						if ($aggregator=='all') {
							
							//遍历全部子节点
							$nextLevel = $doLevel+1;
							$flag = $this->_process($nextLevel);
							
						} else { //any
							
						}
					} else {
						//叶子节点
						$this->_processLeaf($_node);
						
					}
				}	
			}
		}
			
	}
	
	public function _processLeaf($_node) {
		
		$type = $_node['combination']['type'];
		$operator = $_node['combination']['operator'];
		$value = $_node['combination']['value'];
		$valueArr = explode("|",$value);
		
		if ($type=='url') {
			
		} else if ($type=='page_tag_h1') {
			
		} else if ($type=='page_tag_h2') {
			
		} else if ($type=='page_tag_h3') {
			
		} else if ($type=='meta_title') {
			
		} else if ($type=='meta_keyword') {
			
		} else if ($type=='meta_description') {
			
		} else if ($type=='page_txt') {
			//die('全部分类');
			$action = count($valueArr)>1 ? $valueArr[1] : false;
			$connect = $this->getWriteConnect();
			if (strstr($valueArr[0],'{{全部分类}}')) {
				$catArr = array();
				$categories = Mage::getResourceModel('edm/product_category_collection');
				foreach ($categories as $_c) {
					$catArr[$_c->getName()] = $_c->getId();
				}
				
				$values = explode(';',$this->_getValue($valueArr[0]));
				$catsEdmert = array();
				if ($this->_client && $this->_client->getId()) {
					$texts = $this->getClientTextMerge($this->_client->getId());
					
					$limitCount = 30;
					$curCount = 1;
					$tstr = 'Lime,Copper,Cans,Tea,Map,Clipboard,Calendar,Board,Books,Coal,Steel,Lead,Iron,Carbon,Gates,Gambling,Golf,PBX,Safes,Locks,Key,Alarm,PDAs,Boots,Container,Bus,UTV,ATV,Grain,Fruit,Feed,Accessories,Servers,Ore,Coffee,Store';
					$excludeWordArr = explode(',',strtolower($tstr));
					foreach ($values as $_v) {
						
						if (in_array((int)$catArr[$_v],$catsEdmert)) {
							continue;
						}
						$v2 = explode(' & ',$_v);
						$_vCopyt = explode(' ',$_v);
						//单个词匹配不准确
						if (count($_vCopyt)<=1) {
							if (in_array($_v,$excludeWordArr)) { //通用词，过滤
								continue;
							}
						}
						
						foreach ($v2 as $_v2) {
							
							//应该先做行业判断
							if (in_array(strtolower($_v),$excludeWordArr)) { //通用词，过滤
								continue;
							}
							$_v2 = trim($_v2);
							$_vCopyt2 = explode(' ',$_v2);
							$_vCopytLen2 = count($_vCopyt2);
							if ($_vCopytLen2 <= 1) {
								if (in_array(strtolower($_v2),$excludeWordArr)) { //通用词，过滤
									continue;
								}	
							}
							if (in_array((int)$catArr[$_v],$catsEdmert)) {
								continue;
							}
							
							
							if ($_vCopytLen2==1) {
								
								if (strstr($texts,$_v2)) {
									
									if ($curCount<=$limitCount) {
										$sql = "replace into edm_client_category (client_id,category_id) values ('".(int)$this->_client->getId()."','".(int)$catArr[$_v]."') ";
										//echo $_v."<br/>";
										$flag = $connect->query($sql);
										$curCount++;
										array_push($catsEdmert,(int)$catArr[$_v]);
									}
								}
								
							} else {
								
								if (strstr($texts,$_v2) || $this->matchStemmer($texts,$_v2)) { // || strstr($texts,$_v2)
									
									if ($curCount<=$limitCount) {
										$sql = "replace into edm_client_category (client_id,category_id) values ('".(int)$this->_client->getId()."','".(int)$catArr[$_v]."') ";
										//echo $_v."<br/>";
										$flag = $connect->query($sql);
										$curCount++;
										array_push($catsEdmert,(int)$catArr[$_v]);
									}
								}
							}
						}	
					}
				} else {
					foreach ($values as $_v) {
						//使用Sphinx进行匹配
						$sphinxHelper = $this->_sphinx;
						$sphinxHelper->setMatchMode($operator);
						$result = $sphinxHelper->query($_v,$this->_defaultIndex);
						if ($action && count($result['matches'])) { //条件后面跟动作
							
							if ($action=='apply') {
								
								//匹配分类，更新客户分类
								$totalFound = $result['total_found'];
								$total = $result['total'];
								foreach ($result['matches'] as $_m) {
									//
									//echo "<xmp>";var_dump($catArr[$_v]); echo "</xmp>";
									$attrs = $_m['attrs'];
								
									$sql = "replace into edm_client_category (client_id,category_id) values ('".(int)$attrs['client_id']."','".(int)$catArr[$_v]."') ";
									$flag = $connect->query($sql);
								}
							}
						}
					}
					
					
						
				}
			} else {
				$values = explode(',',$valueArr[0]);
				$actionArr = json_decode($valueArr[1],true);
				$texts = $this->getClientTextMerge($this->_client->getId());
				if ($actionArr['type']=='attr' && $actionArr['mode']=='update') {
					if ($this->_client && $this->_client->getId()) {
						//echo '***'.$texts."******<br/>";
						$attrId = $this->_attr[$actionArr['name']]['id'];
						foreach ($values as $_v) {	
							
							if (strstr($texts,$_v) || $this->matchStemmer($texts,$_v)) {
								
								if ($this->_attr[$actionArr['name']]['type']=='select' || $this->_attr[$actionArr['name']]['type']=='multiselect') {
									$tmpValue = $this->_attr[$actionArr['name']]['options'][$actionArr['value']];
								}
								//echo "<xmp>";var_dump($actionArr); echo "</xmp>";
								$clientId = $this->_client->getId();
								$sql = "replace into edm_client_attr_value(attr_id,client_id,value) values('$attrId','$clientId','$tmpValue')";
								
								//echo $sql;
								$flag = $connect->query($sql);
							}
						}

					} else {
						foreach ($values as $_v) {
							//使用Sphinx进行匹配
							$sphinxHelper = $this->_sphinx;
							$sphinxHelper->setMatchMode($operator);
							
							$result = $sphinxHelper->query($_v,$this->_defaultIndex);
							
							if ($actionArr && count($result['matches'])) { //条件后面跟动作
								foreach ($result['matches'] as $_m) {
									$attrId = $this->_attr[$actionArr['name']]['id'];
									$attrs = $_m['attrs'];
									$clientId = (int)$attrs['client_id'];
									$tmpValue = $actionArr['value'];
									if ($this->_attr[$actionArr['name']]['type']=='select' || $this->_attr[$actionArr['name']]['type']=='multiselect') {
										$tmpValue = $this->_attr[$actionArr['name']]['options'][$actionArr['value']];
									}
									//echo "<xmp>";var_dump($actionArr); echo "</xmp>";
									$sql = "replace into edm_client_attr_value(attr_id,client_id,value) values('$attrId','$clientId','$tmpValue')";
									
										//echo $sql;
									$flag = $connect->query($sql);
								}
							}
						}
					}
				} else if ($actionArr['type']=='field' && $actionArr['mode']=='update_count') {
					if ($this->_client && $this->_client->getId()) {
						$updateCount = 0;
						$texts = $this->getClientTextMerge($this->_client->getId());
						foreach ($values as $_v) {	
							
							$subcount = mb_substr_count($texts,$_v);
							$updateCount += $subcount;
							
						}
						if ($updateCount) {
							$sql = "update edm_client set ".$actionArr['name']."=".$updateCount. " where client_id='".$this->_client->getId()."'";
							
							$flag = $connect->query($sql);
						}
							
					} else {
						$clients = Mage::getResourceModel('edm/client_collection');
						if ($this->_client) {
							$clients->addFieldToFilter('client_id',$this->_client->getId());
						}
						
						foreach ($clients as $_client) {
							$updateCount = 0;
							foreach ($values as $_v) {
								
								$sphinxHelper = $this->_sphinx;
								$sphinxHelper->setMatchMode($operator);
								$sphinxHelper->setFilter('client_id',array($_client->getId()));
								
								$result = $sphinxHelper->query($_v,$this->_defaultIndex);
								//var_dump($result);
								if(count($result['matches'])) { //条件后面跟动作
									//echo "<xmp>";var_dump($_client->getId()); echo "</xmp>";
									foreach($result['words'] as $_w) {
										$updateCount += (int)$_w['hits'];
									}
								}		
							}
							if ($updateCount) {
								$sql = "update edm_client set ".$actionArr['name']."=".$updateCount. " where client_id='".$_client->getId()."'";
								
								
								$flag = $connect->query($sql);
							}
						}	
							
					}
						
					
				}

			}
		}
	}
	public function getClientTextMerge($clientId) {
		if (!$this->_clientTextMerge) {
			$texts = $this->getClientText($clientId);
			$str = '';
			foreach ($texts as $_text) {
				$str .= '\n'.$_text->getData('content_text');
			}
			$this->_clientTextMerge = $str;
		}
		return $this->_clientTextMerge;
	}
	public function getClientText($clientId) {
		if (!$this->_clientTexts) {
			$this->_clientTexts = Mage::getResourceModel('edm/client_text_collection')
				->addFieldToFilter('client_id',$clientId);
		}
		return 	$this->_clientTexts;
	}
	/**
	 * 获取值（解析变量）
	 */
	protected function _getValue($value) {
		if(preg_match_all(self::PATTERN_RULE_VARIABLE, $value, $constructions, PREG_SET_ORDER)) {
			
    		$construction[1] = trim($construction[1]);
    		foreach($constructions as $index=>$construction) {
    			
    			if ($construction[1] && array_key_exists($construction[0],$this->_variables)) {
    				
    				$value = str_replace($construction[0],$this->_variables[$construction[0]],$value);
    			}
    		}
		}

		return $value;
	}
	
	
	public function processEmail($client) {
		$clientId = $client->getId();
		$website = $client->getWebsite();
		$texts = Mage::helper('edm/front_client')->getClientTextCollection($clientId);
		foreach ($texts as $_text) {
			$emailArr = $this->getEmails(trim($_text->getData('content_text')));
			$oldEmails = array();
			$emails = Mage::getResourceModel('edm/client_email_collection')
					->addFieldToFilter('client_id',$clientId);
			foreach ($emails as $_item) {
				array_push($oldEmails,$_item->getEmail());
			}
			$emailArr = array_unique($emailArr);
			foreach ($emailArr as $_email) {
				//echo "<xmp>";var_dump($oldEmails); echo "</xmp>";die();
				
				if (!in_array($_email,$oldEmails)) {
					
					$emailModel = Mage::getModel('edm/client_email')
						->setData('client_id',$clientId)
						->setData('email',$_email)
						->setData('source',2)
						->save();
				}
					
					
			}
		}
		
		$oldEmails = array();
		$emails = Mage::getResourceModel('edm/client_email_collection')
				->addFieldToFilter('client_id',$clientId);
		foreach ($emails as $_item) {
			array_push($oldEmails,$_item->getEmail());
		}
		$emailArr = array_unique($emailArr);
		//whois
		//$website = 'bathstore.com';
		/*
		    //暂时屏蔽whois接口
			$domain = Mage::helper('edm/whois')->init($website);
			$info = $domain->info();
			
			$emails = $this->getEmails($info);
			$emails = array_unique($emails);
			foreach ($emails as $_email) {
				if (!strstr($_email,'abuse')) {
					if (!in_array($_email,$oldEmails)) {
						
						$emailModel = Mage::getModel('edm/client_email')
							->setData('client_id',$clientId)
							->setData('source',1)
							->setData('email',$_email)
							->save()
							;
					}
				}	
			}
			//获取所在国家
			$country = $domain->getValueByKey('Registrant Country');
			//var_dump($country);
			if ($country) {
				$client->setCountry($country);
			}
			$clientName = $domain->getValueByKey('Registrant Organization');
			if ($clientName) {
				$client->setName($clientName);
			}
			$clientContact = $domain->getValueByKey('Registrant Name');
			if ($clientContact) {
				$client->setData('contact_person',$clientContact);
			}
		*/
		$client->save();
	}
	
	function getEmails($str) {                                 //匹配邮箱内容
		$pattern = "/([a-z0-9\-_\.]+@[a-z0-9]+\.[a-z0-9\-_\.]+)/"; 
		if (preg_match_all($pattern,$str,$emailArr)) {
			//var_dump($emailArr[0]);die();
			return $emailArr[0]; 
		} else {
			return array();
		}

	}
	
	/***
	 * 匹配Stemmer 匹配后的数据
	 */
	public function matchStemmer($str,$word) {
		
		$word = str_replace('  ',' ',$word);
		$arr = explode(' ',$word);
		$len = count($arr);
		if ($len==1) {
			return false;
		} else if ($len==2) {
			$arr[0] = Mage::helper('edm/stemmer')->Stem($arr[0]);
			$arr[1] = Mage::helper('edm/stemmer')->Stem($arr[1]);
			if (preg_match("/".$arr[0]."([a-z])*[\s]+".$arr[1]."([a-z])+/i",$str)) {
				return true;
			}
		} else if ($len==3) {
			$arr[0] = Mage::helper('edm/stemmer')->Stem($arr[0]);
			$arr[1] = Mage::helper('edm/stemmer')->Stem($arr[1]);
			$arr[2] = Mage::helper('edm/stemmer')->Stem($arr[2]);
			if (preg_match("/".$arr[0]."([a-z])*[\s]+".$arr[1]."([a-z])*[\s]+".$arr[2]."([a-z])+/i",$str)) {
				return true;
			}
		} else if ($len==4) {
			$arr[0] = Mage::helper('edm/stemmer')->Stem($arr[0]);
			$arr[1] = Mage::helper('edm/stemmer')->Stem($arr[1]);
			$arr[2] = Mage::helper('edm/stemmer')->Stem($arr[2]);
			$arr[3] = Mage::helper('edm/stemmer')->Stem($arr[3]);
			if (preg_match("/".$arr[0]."([a-z])*[\s]+".$arr[1]."([a-z])*[\s]+".$arr[2]."([a-z])*[\s]+".$arr[3]."([a-z])+/i",$str)) {
				return true;
			}
		}
		return false;	
	}
}
?>

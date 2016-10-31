<?php
/****
 * 预处理文本
 * 
 * 1.提取邮箱
 * 2.统计四个维度关注点的数量
 * 3.分析 Meta Keyword，如果有keyword，忽略文本详情 
 * 4.如果 Meta Keyword 没有内容，则分析文本详情（去掉空格、空行，去掉stopword，更新文本详情）
 * 4-1.如果非英语 使用状态位标注（记录国家）
 * 5.生成中间表，放分析好的数据，方便同步到线上，每个客户只生成一条临时记录
 * 5-1 表结构 edm_client_offline: 和edm_client 一样，额外多 emails字段+
 * 6.如果线上已有该表，则合并两表
 * 7.分析好，生成中间表之后，归档文本 text_ymdH 每小时归档 ？
 * 7-1.另外一个进程对中间表进行同步操作，用PHP操作链接远程和本地数据库，直接更新数据库
 * 7-2.中间表处理完成后，设置状态位，并
 */

class Mage_Edm_Helper_Client_Textoffline extends Mage_Core_Helper_Abstract
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
	
	protected function _init($rule,$client) {
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
	public function process($rule,$client) {
		$this->_init($rule,$client);
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
				if ($_node['level']==$doLevel) {
					if (array_key_exists('aggregator',$_node['combination'])) { //条件组合
						$aggregator = $_node['combination']['aggregator'];
						$value = $_node['combination']['value'];
						if ($aggregator=='all') {
							$nextLevel = $doLevel+1;
							$flag = $this->_process($nextLevel);
						}
					} else {
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
			$action = count($valueArr)>1 ? $valueArr[1] : false;
			$connect = $this->getWriteConnect();
			if (strstr($valueArr[0],'{{全部分类}}')) {
				//do nothing,将来用一个识别产品的单独类来处理（识别产品为关键字）
			} else {
				$values = explode(',',$valueArr[0]);
				$actionArr = json_decode($valueArr[1],true);
				$texts = $this->getClientTextMerge($this->_client->getId());
				if ($actionArr['type']=='attr' && $actionArr['mode']=='update') {
					$attrId = $this->_attr[$actionArr['name']]['id'];
					$attrData = array();
					foreach ($values as $_v) {
						if (strstr($texts,$_v) || $this->matchStemmer($texts,$_v)) {
							if ($this->_attr[$actionArr['name']]['type']=='select' || $this->_attr[$actionArr['name']]['type']=='multiselect') {
								$tmpValue = $this->_attr[$actionArr['name']]['options'][$actionArr['value']];
							}
							$clientId = $this->_client->getId();
							$tmp = array(
								'attr_id'=>$attrId,
								'value' => $tmpValue,
							);
							array_push($attrData, $tmp);
						}
					}
					//保存为JSON
					$client->setData('attr_json',json_encode($attrData));
				} else if ($actionArr['type']=='field' && $actionArr['mode']=='update_count') {
					$updateCount = 0;
					$texts = $this->getClientTextMerge($this->_client->getId());
					foreach ($values as $_v) {	
						$subcount = mb_substr_count($texts,$_v);
						$updateCount += $subcount;
					}
					if ($updateCount) {
						//保存字段值
						$client->setData($actionArr['name'],$updateCount);
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
	 * 获取所有邮箱
	 */
	public function processEmail($client) {
		$clientId = $client->getId();
		$website = $client->getWebsite();
		$_text = $this->getClientTextMerge($this->_client->getId());
		$emailArr = $this->getEmails(trim($_text->getData('content_text')));
		$emailArr = array_unique($emailArr);
		$client->setData('emails',implode(',',$emailArr));
		return $this;
	}
	
	/**
	 * 识别邮箱正则
	 */
	function getEmails($str) { 
		$pattern = "/([a-z0-9\-_\.]+@[a-z0-9]+\.[a-z0-9\-_\.]+)/"; 
		if (preg_match_all($pattern,$str,$emailArr)) {
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

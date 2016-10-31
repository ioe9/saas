<?php
/***
 * 客户相关Helper
 */
class Mage_Edm_Helper_Front_Client extends Mage_Core_Helper_Abstract
{
	/**
	 * 根据URL分析客户信息
	 */
	public function analysisUrl($url,$client) {
		$clientId = $client->getId();
		if ($this->isWinOs()) {
			exec("node d:\\nodewww\\51jrh\\edm_client_url.js $clientId $url",$out,$returnVar);
			if ($returnVar==0) { //执行成功
				//var_dump($out);
			} else { //执行失败
				Mage::log('执行CMD命令失败',false,'analysisurl.log');  //记录错误日志
				//var_dump($out);
				echo '执行CMD命令失败';
				return false;
			}
		} else { //centos
			//echo "node /var/nodewww/edm_client_url.js  $clientId $url";return;
			exec("node /var/nodewww/edm_client_url.js  $clientId $url",$out,$returnVar);
			if ($returnVar==0) { //执行成功
				//var_dump($out);
			} else { //执行失败
				Mage::log('执行CMD命令失败',false,'analysisurl.log');  //记录错误日志
				//var_dump($out);
				echo '执行CMD命令失败';
				return false;
			}
		}
		return true;
	}
	
	/***
	 * 根据URL获取客户
	 */
	public function getClientByUrl($url) {
		$cleanUrl = $this->cleanUrl($url);
		$client = Mage::getResourceModel('edm/client_collection')
			->addFieldToFilter('website',array('like'=>'%'.$url))
			->getFirstItem();
		return $client;
	}
	
	/***
	 * 根据Email获取客户
	 */
	public function getClientByEmail($email) {
		$email = $this->cleanEmail($email);
		$client = Mage::getResourceModel('edm/client_collection')
			->addFieldToFilter('email_domain',$email)
			->getFirstItem();
		return $client;
	}
	
	/**
	 * 获取干净的URL
	 */
	public function cleanUrl($url) {
		if (strstr($url,'http')) {
			$domain = '';
			$temp=parse_url($url);  
			//var_dump($temp);
			$domain=$temp['host'];  
			if ($domain=='alibaba') {
				
			} else {
				$url = $domain;
			}
			return $url;
		} else {
			$temp = explode('/',$url);
			return $temp[0];
		}
	}
	
	/**
	 * 获取Email Domain
	 */
	public function cleanEmail($email) {
		//验证邮箱合法性
		
		$temp = explode('@',$email);
		return $temp[1];

	}
	
	//更新索引
	public function anyIndexer() {
		if ($this->isWinOs()) {
			//更新增量索引
			//echo "更新增量索引";
			
			exec("indexer.exe delta --rotate --config d:\\sphinx\\bin\\sphinx.conf 2>&1",$out,$returnVar);
			if ($returnVar!=0) { //执行成功
				
				Mage::log('执行CMD命令失败 indexer.exe delta --rotate --config',false,'analysisindexer.log');  //记录错误日志
				echo '执行CMD命令失败 indexer delta --rotate --config';
				return false;
			}
			
			//合并增量索引到主索引
			exec("indexer.exe --merge test1 delta --rotate --config d:\\sphinx\\bin\\sphinx.conf 2>&1",$out,$returnVar);
			if ($returnVar==0) { //执行成功
			} else { //执行失败
				Mage::log('执行CMD命令失败',false,'analysisindexer.log');  //记录错误日志
				echo '执行CMD命令失败';;
				return false;
			}
			//exec("d:\\sphinx\\bin\\indexer --all --rotate");
		} else {
			//更新增量索引
			//echo "更新增量索引";
			/*
			exec("/usr/bin/indexer delta --rotate 2>&1",$out,$returnVar);
			
			if ($returnVar!=0) { //执行成功
				var_dump($out);
				Mage::log('执行CMD命令失败 indexer delta --rotate  2>&1',false,'analysisindexer.log');  //记录错误日志
				echo '执行CMD命令失败 indexer delta --rotate --config ';
				return false;
			}
			
			//合并增量索引到主索引
			exec("/usr/bin/indexer --merge test1 delta --rotate 2>&1",$out,$returnVar);
			if ($returnVar==0) { //执行成功
			} else { //执行失败
				Mage::log('执行CMD命令失败',false,'analysisindexer.log');  //记录错误日志
				echo '执行CMD命令失败 indexer --merge test1 delta --rotate --config \/etc\/sphinx\/sphinx.conf 2>&1';;
				return false;
			}*/
			//exec("d:\\sphinx\\bin\\indexer --all --rotate");
		}
	}
	
	/**
	 * 判断当前OS是否windows
	 */
	public function isWinOs() {
		return strtoupper(substr(PHP_OS,0,3))==='WIN'? true:false; 
	}
	
	
	public function getClientTextCollection($clientId) {
		return Mage::getResourceModel('edm/client_text_collection')
			->addFieldToFilter('client_id',$clientId);
		
			
	}
}

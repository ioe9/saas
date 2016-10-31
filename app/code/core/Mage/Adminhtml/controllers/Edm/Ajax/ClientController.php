<?php
/**
 * 客户相关操作
 */
class Mage_Adminhtml_Edm_Ajax_ClientController extends Mage_Adminhtml_Controller_Edm
{
	/**
	 * 根据URL分析客户:先抓取
	 * 1.先判断库里是否已有分析好的数据
	 * 2.否则调用Nodejs并发抓取
	 * URL判别唯一客户标准
	 * 1.大平台
	 * 2.客户官方
	 */
	public function urlAction() {
		//ini_set("max_execution_time",  "30"); //30秒
		$url = $this->getRequest()->getParam('url');
		$clientHelper = Mage::helper('edm/front_client');
		$url = $clientHelper->cleanUrl($url);
		$client = $clientHelper->getClientByUrl($url);
		$company = Mage::registry('current_company');
		$res = array('ret'=>-1,'msg'=>'');
		if ($url) {
			if ($client && $client->getId()) { //客户已存在库里，直接读库
				//判断是否抓取过文件
				$texts = $clientHelper->getClientTextCollection($client->getId());
				//var_dump($texts->count());
				if (count($texts)<1) {
					$flag = $clientHelper->analysisUrl('http://'.$url,$client);
					if ($flag) {
						$res['ret'] = 1;
					} else {
						
					}
				} else {
					//判断是否解析过
					//$data = $this->getAnalysisMap($client);
					$clientCats = Mage::getResourceModel('edm/client_category_collection')
						->addFieldToFilter('client_id',$client->getId());
						
					if ($client->getData('node_analysis_flag')==1 && $clientCats->count()) {
						$data = $this->getAnalysisMap($client,false);
					} else {
						//更新分析状态，不需重新分析			
							
						$data = $this->getAnalysisMap($client);
						$client->setData('node_analysis_flag',1)->save();
					}
					
					$output = $data['output'];
					
					if (count($data['cat'])) {
						
						
						
						$urlExits = Mage::getResourceModel('edm/urlprocess_collection')
							->addFieldToFilter('url',$url)
							->addFieldToFilter('company_id',$company->getId())
							->getFirstItem();
						if (!$urlExits->getId()) {
							$urlprocess = Mage::getModel('edm/urlprocess');	
							$urlData = array(
								'url'=>$url,
								'company_id'=>$company->getId(),
								'position' => 99,
								'is_active' => 1,
								'status' => 2,
							);
							try {
								$urlprocess->addData($urlData)->save();
								
							} catch (Exception $e) {
								
							}
						}
				
				
				
						$res['data'] = $output;
						$res['ret'] = 1;
					} else {
						$res['ret'] = 0;
					}
				}
				
			}  else {
				//插入到客户表,创建用户
				$client = Mage::getModel('edm/client')
					->setData('website',$url)
					->save();
				$urlExits = Mage::getResourceModel('edm/urlprocess_collection')
					->addFieldToFilter('url',$url)
					
					->getFirstItem();
				if (!$urlExits->getId()) {
					$urlprocess = Mage::getModel('edm/urlprocess');	
					$urlData = array(
						'url'=>$url,
						'company_id'=>$company->getId(),
						'position' => 99,
						'is_active' => 1,
					);
					try {
						$urlprocess->addData($urlData)->save();
						
					} catch (Exception $e) {
						
					}
				}
					
				//
				$flag = $clientHelper->analysisUrl('http://'.$url,$client);
				if ($flag) {
					//$res['ret'] = 1;
				} else {
					
				}
			}
		}
			
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));
	}
	
	/****
	 * 根据关键字搜索对应客户列表
	 */
	public function keywordAction() {
		$keyword = $this->getRequest()->getParam('q');
		if ($keyword && strlen($keyword)>2) {
			$urlExits = Mage::getResourceModel('edm/company_keyword_collection')
					->addFieldToFilter('keyword',$keyword)
					->addFieldToFilter('company_id',$company->getId())
					->getFirstItem();
				if (!$urlExits->getId()) {
					$urlprocess = Mage::getModel('edm/urlprocess');	
					$urlData = array(
						'keyword'=>$keyword,
						'company_id'=>$company->getId(),
						'position' => 99,
						'is_active' => 1,
						'status' => 2,
					);
					try {
						$urlprocess->addData($urlData)->save();
						
					} catch (Exception $e) {
						
					}
				}
		}
	}
	
	public function getmailAction() {
		$templateId = $this->getRequest()->getParam('template_id',false);
		$url = $this->getRequest()->getParam('url');
		$email = $this->getRequest()->getParam('email',false);
		$productNames = explode(';',$this->getRequest()->getParam('product',''));
		$productNamesPromo = $this->getRequest()->getParam('product_promo','');
		$user = Mage::getSingleton('admin/session')->getUser();
		$company = Mage::registry('current_company');
		$res = array('ret'=>-1,'msg'=>'');
		if ($url) {
			//有URL
			$clientHelper = Mage::helper('edm/front_client');
			$url = $clientHelper->cleanUrl($url);
			$client = $clientHelper->getClientByUrl($url);
			
			
			if ($url && $client && $client->getId()) {
				$template = Mage::getModel('edm/company_template')->load($templateId);
				
				Mage::register('current_template',$template,true);
				if (count($productNames)) {
					$client->setData('selected_product',implode(' & ',$productNames));
				}
				//$client->setData('selected_product',"selected_product");
				if (($productNamesPromo)) {
					Mage::register('product_promo',$productNamesPromo,true);
				}	
				
				
				$emailModel = Mage::getModel('edm/client_email');
				$emailTo = '';
				if ($email) {
					$emailModel = $emailModel->loadByEmail($client,$email);
					if ($emailModel->getId()) {
						Mage::register('current_contact',$emailModel);
						$emailTo = $email;
					}
				}
				$data = $this->getEmailOutput($client,$emailTo); 
				
				
				
				$output = $data['output'];
				$res['data'] = $output;
				$res['client_id'] = $client->getId();
				$res['ret'] = 1;
				
				
				/****************** 记录搜索记录  *************************************************/
				$keywordExits = Mage::getResourceModel('edm/company_keyword_collection')
					->addFieldToFilter('keyword',$productNamesPromo)
					->addFieldToFilter('company_id',$company->getId())
					->getFirstItem();
				if (!$keywordExits->getId()) {
					$keywordModel = Mage::getModel('edm/company_keyword');	
					$keywordData = array(
						'keyword'=>$productNamesPromo,
						'company_id'=>$company->getId(),
						'user_id' => $user->getId(),
						'is_active' => 1,
					);
					try {
						$keywordModel->addData($keywordData)->save();
					} catch (Exception $e) {
						
					}
				}	
				/*******************************************************************/
				
				
			} else {
				$res['msg'] = "客户不存在！";
			}
		} else {
			//无URL
			$clientHelper = Mage::helper('edm/front_client');
			$client = $clientHelper->getClientByEmail($email);
			if (!$client || !$client->getId()) {
				$client = new Varien_Object();
			}
			$template = Mage::getModel('edm/company_template')->load($templateId);
			
			Mage::register('current_template',$template,true);
			if (count($productNames)) {
				$client->setData('selected_product',implode(' & ',$productNames));
			}
			if (($productNamesPromo)) {
				Mage::register('product_promo',$productNamesPromo,true);
			}
			$emailModel = Mage::getModel('edm/client_email');
			$emailTo = '';
			if ($email) {
				$emailModel = $emailModel->loadByEmail($client,$email);
				if ($emailModel->getId()) {
					Mage::register('current_contact',$emailModel);
					$emailTo = $email;
				}
			}
			$data = $this->getEmailOutput($client,$emailTo); 
			$output = $data['output'];
			$res['data'] = $output;
			$res['client_id'] = $client->getId();
			$res['ret'] = 1;
			
			
			/****************** 记录搜索记录  *************************************************/
			$keywordExits = Mage::getResourceModel('edm/company_keyword_collection')
				->addFieldToFilter('keyword',$productNamesPromo)
				->addFieldToFilter('company_id',$company->getId())
				->getFirstItem();
			if (!$keywordExits->getId()) {
				$keywordModel = Mage::getModel('edm/company_keyword');	
				$keywordData = array(
					'keyword'=>$productNamesPromo,
					'company_id'=>$company->getId(),
					'user_id' => $user->getId(),
					'is_active' => 1,
				);
				try {
					$keywordModel->addData($keywordData)->save();
				} catch (Exception $e) {
					
				}
			}
		}
			
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));	
	}
	
	/***
	 * 保存草稿
	 */
	public function saveDraftAction() {
		$res = array('ret'=>-1,'msg'=>'');
		$templateId = $this->getRequest()->getParam('template_id',false);
		$emailFrom = $this->getRequest()->getParam('email_from','');
		$emailTo = $this->getRequest()->getParam('email_to','');
		$emailSubject = $this->getRequest()->getParam('email_subject','');
		$emailBody = $this->getRequest()->getParam('email_body','');
		
		$ccMe = $this->getRequest()->getParam('cc_me',0);
		$productNamesPromo = $this->getRequest()->getParam('product_promo','');
		$user = Mage::getSingleton('admin/session')->getUser();
		$company = Mage::registry('current_company');
		//email_subject:,email_body:email_body,cc_me:cc_me
		
		if ($emailBody) {
			$draftContent = array(
				'template_id' => $emailBody,
				'email_from' => $emailFrom,
				'email_to' => $emailTo,
				'email_subject' => $emailSubject,
				'email_body' => $emailBody,
				
				'cc_me' => $ccMe,
				'product_promo' => $productNamesPromo,
			);
			$data = array(
				'draft_user' => $user->getId(),
				'draft_company' => $company->getId(),
				'draft_content' => json_encode($draftContent),
				'draft_config' => json_encode(array()),
				'is_system' => 1,
			);
			$draft = Mage::getModel('edm/company_draft');
			$draft->addData($data);
			try {
				$draft->save();
				$res['ret'] = 1;
				$res['data'] = array('draft_id'=>$draft->getId());
			} catch (Exception $e) {
				//记录异常，并监控
				$res['msg'] = '';
			}
		} else {
			$res['msg'] = "提交参数错误";
		}
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));
		
	}
	public function whoisAction() {
		$url = $this->getRequest()->getParam('url');
		$clientHelper = Mage::helper('edm/front_client');
		$url = $clientHelper->cleanUrl($url);
		$client = $clientHelper->getClientByUrl($url);
		
		$res = array('ret'=>-1,'msg'=>'');
		if ($url) {
			if ($client && $client->getId() && !$client->getData('whois_flag')) {
				$oldEmails = array();
				$emails = Mage::getResourceModel('edm/client_email_collection')
						->addFieldToFilter('client_id',$client->getId());
				foreach ($emails as $_item) {
					array_push($oldEmails,$_item->getEmail());
				}
				$emailArr = array_unique($emailArr);
				$domain = Mage::helper('edm/whois')->init($url);
				$info = $domain->info();
				
				$emails = Mage::helper('edm/client_text')->getEmails($info);
				$emails = array_unique($emails);
				foreach ($emails as $_email) {
					if (!strstr($_email,'abuse')) {
						if (!in_array($_email,$oldEmails)) {
							
							$emailModel = Mage::getModel('edm/client_email')
								->setData('client_id',$client->getId())
								->setData('source',1)
								->setData('email',$_email)
								->save();
						}
					}	
				}
				//获取所在国家
				$client->load($client->getId());
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
				$client->setData('whois_flag',1);
				//echo $client->getData('contact_person');
				$client->save();
				$res['ret'] = 1;
			} else {
				$res['ret'] = 0;
			}
		}
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));	
	}
	
	/***
	 * 模块切换
	 */
	public function switchAction() {
		$templateId = $this->getRequest()->getParam('template',false);
		$clientId = $this->getRequest()->getParam('client_id',false);
		$email = $this->getRequest()->getParam('email',false);
		$productNames = explode(';',$this->getRequest()->getParam('product',''));
		$productNamesPromo = explode(';',$this->getRequest()->getParam('product_promo',''));
		$clientHelper = Mage::helper('edm/front_client');
		$moduleName = $this->getRequest()->getParam('module',false);
		$client = Mage::getModel('edm/client')->load($clientId);
		$res = array('ret'=>-1,'msg'=>'');
		if ($client && $client->getId()) {
			Mage::register('current_client',$client,true);
			if (count($productNames)) {
				$client->setData('selected_product',implode(' & ',$productNames));
			}
			if (count($productNamesPromo)) {
				Mage::register('product_promo',implode(' & ',$productNamesPromo),true);
			}	
			
			
			$emailModel = Mage::getModel('edm/client_email');
			$emailTo = '';
			if ($email) {
				$emailModel = $emailModel->loadByEmail($client,$email);
				if ($emailModel->getId()) {
					Mage::register('current_contact',$emailModel);
					$emailTo = $email;
				}
			}
			//
			
			$template = Mage::getModel('edm/company_template')->load($templateId);
			Mage::register('current_template',$template,true);
			$data = Mage::helper('edm/template')->render($template->getData('htmlbody'),$moduleName);
			//var_dump($data);
			//$data = $this->getEmailOutput($client,$emailTo); 
			$output  = $data;
			$res['data'] = $data;
			$res['ret'] = 1;
			
		} else {
			$res['msg'] = "客户不存在！";
		}
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));	
	}
	
	/***
	 * 模块配置
	 */
	public function configAction() {
		$templateId = $this->getRequest()->getParam('template',false);
		$clientId = $this->getRequest()->getParam('client_id',false);
		$email = $this->getRequest()->getParam('email',false);
		$productNames = explode(';',$this->getRequest()->getParam('product',''));
		$productNamesPromo = explode(';',$this->getRequest()->getParam('product_promo',''));
		$clientHelper = Mage::helper('edm/front_client');
		$moduleName = $this->getRequest()->getParam('module',false);
		$client = Mage::getModel('edm/client')->load($clientId);
		$res = array('ret'=>-1,'msg'=>'');
		if ($client && $client->getId()) {
			Mage::register('current_client',$client,true);
			if (count($productNames)) {
				$client->setData('selected_product',implode(' & ',$productNames));
			}
			if (count($productNamesPromo)) {
				Mage::register('product_promo',implode(' & ',$productNamesPromo),true);
			}	
			
			$emailModel = Mage::getModel('edm/client_email');
			$emailTo = '';
			if ($email) {
				$emailModel = $emailModel->loadByEmail($client,$email);
				if ($emailModel->getId()) {
					Mage::register('current_contact',$emailModel);
					$emailTo = $email;
				}
			}
			//
			$template = Mage::getModel('edm/company_template')->load($templateId);
			$module = Mage::getResourceModel('edm/company_template_module_collection')
				->addFieldToFilter('module_name',$moduleName)
				->addFieldToFilter('module_template',$templateId)
				->addFieldToFilter('module_company',Mage::registry('current_company')->getId())
				->getFirstItem();
			Mage::register('current_template',$template,true);
			$data = Mage::helper('edm/template')->render($template->getData('template_body'),$moduleName,true,$templateId);
			Mage::register('current_items',$data,true);
			Mage::register('current_module',$module,true);
			$output = $this->getConfigOutput($data); 
			
			$res['data'] = $output;
			$res['ret'] = 1;
			
		} else {
			$res['msg'] = "客户不存在！";
		}
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));	
	}
	public function getConfigOutput() {
		
		$layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('adminhtml_ins_ajax_client_config');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();
		
        return $output;
	}
	/***
	 * 模块配置保存
	 */
	public function configsaveAction() {
		$templateId = $this->getRequest()->getParam('template',false);
		$clientHelper = Mage::helper('edm/front_client');
		$moduleId = $this->getRequest()->getParam('module',false);
		$company = Mage::registry('current_company');
		$itemIdArr = explode(',',$this->getRequest()->getParam('items',''));
		$res = array('ret'=>-1,'msg'=>'');
		//获取moduleId
		if ($moduleId) {
			
			$oldRelateds = Mage::getResourceModel('edm/company_template_module_item_collection')
				->addFieldToFilter('item_module',$moduleId)
				->addFieldToFilter('item_template',$templateId)
				->addFieldToFilter('item_company',Mage::registry('current_company')->getId());
				//->addFieldToFilter('status',1);
			$oldIds = $oldRelateds->getAllIds();
			
			
			
			
			try {
				
				foreach ($oldIds as $_itemId) {
					$itemModel = Mage::getModel('edm/company_template_module_item')->load($_itemId);
					if ($itemModel->getId()) {
						if (!in_array($_itemId,$itemIdArr)) {
							$itemModel->setData('status',0);
						} else {
							$itemModel->setData('status',1);
						}
						$itemModel->save();
					}	
				}
				
				$res['ret'] = 1;
			} catch (Exception $e) {
				$res['msg'] = "对不起，保存失败，请联系管理员";
			}	
			
		} else {
			$res['msg'] = "请求出错，请重试";
		}
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));	
	}
	public function checksendAction() {
		$emailTo = $this->getRequest()->getParam('email_to',false);
		$res = array('ret'=>-1,'msg'=>'');
		//三天内
		$sends = Mage::getResourceModel('edm/company_email_send_collection')
			->addFieldToFilter('company_id',Mage::registry('current_company')->getId())
			->addFieldToFilter('email_to',$emailTo)
			->addFieldToFilter('date_create',array('gt'=>date('Y-m-d H:i:s',strtotime('-3 days'))));
		if ($sends->count()) {
			$res['ret'] = 0;
			$res['data'] = $sends->count();
		} else {
			$res['ret'] = 1;
		}
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));	
	}
	
	public function sendmailAction() {
		
		$emailFrom = $this->getRequest()->getParam('email_from',false);
		$emailTo = $this->getRequest()->getParam('email_to',false);
		$emailSubject = $this->getRequest()->getParam('email_subject',false);
		$emailBody = $this->getRequest()->getParam('email_body',false);
		$emailFromName = $this->getRequest()->getParam('email_from_name',false);
		$clientId = $this->getRequest()->getParam('client_id',false);
		$cc_me = $this->getRequest()->getParam('cc_me',false);
		
		$res = array('ret'=>-1,'msg'=>'');
		if ($emailFrom && $emailTo && $emailSubject && $emailBody) {
			//Magento邮件发送
			$mail = Mage::getModel('core/email');  
			$mail->setToName('John');  
			$mail->setToEmail($emailTo);  
			$mail->setBody($emailBody);  
			$mail->setSubject($emailSubject);  
			$mail->setFromEmail($emailFrom);  
			$mail->setFromName($emailFromName); 
			if ($cc_me)  {
				//$mail->setCc($emailFrom);
				
			}
			
			$mail->setType('html');// YOu can use Html or text as Mail format  
			//
			try {  
				$mail->send();  
				if ($cc_me)  {
					$mail = Mage::getModel('core/email');  
 
					$mail->setToEmail($emailFrom);  
					$mail->setBody($emailBody);  
					$mail->setSubject($emailSubject);  
					$mail->setFromEmail('1303387324@qq.com');  
					$mail->setFromName('IoeGo.com Admin');  
				}
				//更细您发送记录
				$sendModel  = Mage::getModel('edm/company_email_send');
				$sendData = array(
					'email_from' => $emailFrom,
					'email_to' => $emailTo,
					'subject' => $emailSubject,
					'email_content' => $emailBody,
					'company_id' => Mage::registry('current_company')->getId(),
					'user_id' => Mage::getSingleton('admin/session')->getUser()->getId(),
				);
				$sendModel->addData($sendData)->save();
				
				$res['ret'] = 1;
				
				  
			}  catch (Exception $e) {  
				//$res['msg'] = "邮件发送失败，请稍后重试或联系管理员获取帮助。";
				$res['msg'] = $e->getMessage();
				
			}  
			
			
			
		} else {
			$res['msg'] = "提交的参数有误，请重新提交！";
		}
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));	
	}
	
	/***
	 * Ajax 不断异步请求，获取实时分析结果，处理完成，取消异步请求
	 */
	public function urlresAction() {
		$this->_forward('url');
	}
	
	public function getAnalysisMap($client,$needSphinx=true) {
		//先更新Sphinx索引
		
		//先分析文本类型，目前仅支持URL,Title分析
		
		//更新增量索引 & 合并增量索引到主索引
		$clientHelper = Mage::helper('edm/front_client');
		if (false && $needSphinx) { //已经单独用stemmer来实现
			$clientHelper->anyIndexer();
		}
		
		
		//处理完成，使用sphinx/Stemmer进行分析
		if ($needSphinx) {
			
			$ruleCollection = Mage::getResourceModel('edm/client_rule_collection')
				->addFieldToFilter('status',1);
			$textHelper = Mage::helper('edm/client_text');
			
			$textHelper->processEmail($client);
			foreach ($ruleCollection as $_rule) {
				$ruleFlag = $textHelper->process($_rule,true,$client);
			}
		}
		$client->load($client->getId());
		//返回各个维度分析结果
		//客户分类
		$categories = Mage::getResourceModel('edm/client_category_collection')
			->addFieldToFilter('client_id',$client->getId());
		$categories->getSelect()->join(array('c'=>'ins_product_category'),'main_table.category_id=c.category_id',array('name'));
		//客户属性值
		$attrs = array();
		$attrCollection = Mage::getResourceModel('edm/client_attr_collection')
			->addFieldToFilter('visible_front',1);
		foreach ($attrCollection as $_c) {
			$_values = Mage::getResourceModel('edm/client_attr_value_collection')
				->addFieldToFilter('attr_id',$_c->getId())
				->addFieldToFilter('client_id',$client->getId());
			
			$attrs[$_c->getName()] = array('attr'=>$_c,'value'=>$_values);
		}
		//客户所属邮箱
		$emails = Mage::getResourceModel('edm/client_email_collection')
			->addFieldToFilter('client_id',$client->getId());
		//获取关于我们内容
		$aboutus = Mage::getResourceModel('edm/client_text_collection')
			->addFieldToFilter('pagetype',1)
			->getFirstItem();
		
		$client->setData('categories',$categories);
		$client->setData('attrs',$attrs);
		$client->setData('emails',$emails);
		$client->setData('about-us',$aboutus);
		
		Mage::register("current_client",$client,true);
		$layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('adminhtml_ins_ajax_client_analysis');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();
      
        return array('cat'=>$categories,'output'=>$output);
	}
	
	
	public function getEmailOutput($client,$emailTo) {

		Mage::register('current_client',$client);
		$layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('adminhtml_ins_ajax_client_getemail');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();
		
        return array('output'=>$output);
	}
	
    protected function _isAllowed()
    {
        //return Mage::getSingleton('admin/session')->isAllowed('email');
        return true;
    }
}

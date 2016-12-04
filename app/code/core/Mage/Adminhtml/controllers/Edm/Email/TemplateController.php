<?php
class Mage_Adminhtml_Edm_Email_TemplateController extends Mage_Adminhtml_Controller_Edm
{
    public function indexAction()
    {
    	$this->loadLayout();
    	$this->_title("邮件模板")->_title("邮件");

        $this->_setActiveMenu('edm/email/template');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_template_my', 'template'));
        $this->renderLayout();
    }
    public function newAction() {
    	$this->_forward('edit');
    }
    public function viewAction() {
    	$this->_forward('edit');
    }
    public function enableAction() {
    	$templateId = (int)$this->getRequest()->getParam('id');
    	$template = Mage::getModel('edm/company_template')->load($templateId);
    	if ($template->getId() && $template->getData('template_company') == $this->_getCompanyId()) {
    		try {
    			$template->setData('template_status',Mage_Edm_Model_Company_Template::STATUS_ENABLE)
    				->save();
    			$this->_getSession()->addSuccess("启用成功。");
    		} catch (Exception $e) {
    			$this->_getSession()->addError("请求出错，请刷稍后重试。");
    		}
    		
		} else {
			$this->_getSession()->addError("无效请求，请刷新后重试。");
    	}
    	$this->_redirect('*/*/');
    }
    public function disableAction() {
    	$templateId = (int)$this->getRequest()->getParam('id');
    	$template = Mage::getModel('edm/company_template')->load($templateId);
    	if ($template->getId() && $template->getData('template_company') == $this->_getCompanyId()) {
    		try {
    			$template->setData('template_status',Mage_Edm_Model_Company_Template::STATUS_DISABLE)
    				->save();
    			$this->_getSession()->addSuccess("禁用成功。");
    		} catch (Exception $e) {
    			$this->_getSession()->addError("请求出错，请刷稍后重试。");
    		}
    		
		} else {
			$this->_getSession()->addError("无效请求，请刷新后重试。");
    	}
    	$this->_redirect('*/*/');
    }
    public function editAction()
    {
    	$templateId = (int)$this->getRequest()->getParam('id');
    	$this->loadLayout();
    	
    	$this->_title("邮件模板")->_title("编辑/查看");
		$template = Mage::getModel('edm/company_template')->load($templateId);
		Mage::register('current_template',$template);
        $this->_setActiveMenu('edm/email/template_new');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_template_edit', 'template.edit'));
        $this->renderLayout();
    }
    
    /***
     * 保存模板内容
     */
    public function saveAction() {
    	
    	$templateId = (int)$this->getRequest()->getParam('id');
    	$data = $this->getRequest()->getParams();
    	$template = Mage::getModel('edm/company_template')->load($templateId);
    	if ($template->getId() && $template->getData('template_company')!=$this->_getCompanyId()) {
			$this->_getSession()->addError("非法请求，您的IP已被记录！");
			$this->_redirect('*/*/');
			return;
    	}
    	$arr = array();
    	if (!$templateId) {
    		$arr['template_company'] = $this->_getCompanyId();
	    	$arr['template_create'] = Mage::registry('current_user')->getId();
	    	$arr['template_parent'] = (int)$data['template_parent'];
	    	$arr['template_scene'] = (int)$data['template_scene'];
    	}
	    	
    	$arr['template_name'] = trim($data['template_name']);
    	$arr['template_position'] = intval($data['template_position']);
    	$arr['template_memo'] = trim($data['template_memo']);
    	$arr['is_mark'] = intval($data['is_mark']);
    	$arr['template_status'] = intval($data['template_status']);
    	$arr['visible_scope'] = intval($data['visible_scope']);
    	//可见人员 TODO...
    	//$arr['template_body'] = trim($data['template_body']);
    	$template->addData($arr);
    	try {
    		$template->save();
    	} catch (Exception $e) {
    		$this->_getSession()->addError("请求出错，请重试或联系管理员。");
			$this->_redirect('*/*/');
			return;
    	}
    	$this->_redirect('*/*/edit',array('id'=>$template->getId()));
    }
    
    /****
     * 增加模块
     */
    public function addModuleAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
			'msg' => '',
		);
    	$templateId = (int)$this->getRequest()->getParam('id');
    	$moduleIdStr = trim($this->getRequest()->getParam('module_ids'));
    	$template = Mage::getModel('edm/company_template')->load($templateId);
    	$moduleIdArr = explode(',',$moduleIdStr);
    	
    	if ($template->getId() && count($moduleIdArr)) {
    		if ($template->getData('template_company') != $this->_getCompanyId() || $template->getData('template_create')!=Mage::registry('current_user')->getId()) {
    			$res['msg'] = "权限不足，请确认。";
    		} else {
    			$dataLinkId = array();
    			//获取上一个最大排序值
    			$nextSort = $template->getNextLinkSort();
    			foreach ($moduleIdArr as $moduleId) {
    				$link = Mage::getModel('edm/company_template_module_link');
    				$linkData = array(
						'link_template'=>$templateId,
						'link_module'=>$moduleId,
						'link_order'=> $nextSort);
    				
    				$link->addData($linkData);
    				try {
    					$link->save();
    					array_push($dataLinkId,$link->getId().'_'.$moduleId.'_'.$nextSort);
    				} catch (Exception $e) {
    					$data['succeed'] = false;
    					break;
    				}
    				$nextSort++;
    			}
    			$res['data'] = $dataLinkId;
    		}
    	} else {
    		$data['succeed'] = false;
    		$res['msg'] = "无效请求，请刷新后重试。";
    	}
    	echo json_encode($res);
    }
    public function deleteModuleAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
			'msg' => '',
		);
    	$linkId = (int)$this->getRequest()->getParam('link_id');
    	$link = Mage::getModel('edm/company_template_module_link')->load($linkId);
    	$template = Mage::getModel('edm/company_template')->load($link->getLinkTemplate());
    	if ($linkId && $template->getId() && 
    		$template->getData('template_company') == $this->_getCompanyId() && 
    		$template->getData('template_create')==Mage::registry('current_user')->getId()) {
    		try {
    			$link->delete();
    		} catch (Exception $e) {
    			$data['succeed'] = false;
    			$res['msg'] = "请求出错，请刷新后重试。";
    		}
    	} else {
    		$res['succeed'] = false;
    		$res['msg'] = "无效请求，请刷新后重试。";
    	}
    	echo json_encode($res);
    }
    public function deleteItemAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
			'msg' => '',
		);
    	$itemId = (int)$this->getRequest()->getParam('item_id');
    	$item = Mage::getModel('edm/company_template_module_item')->load($itemId);
    	$link = Mage::getModel('edm/company_template_module_link')->load($item->getData('item_link'));
    	$template = Mage::getModel('edm/company_template')->load($link->getLinkTemplate());
    	if ($itemId && $link->getId() && $template->getId() && 
    		$template->getData('template_company') == $this->_getCompanyId() && 
    		$template->getData('template_create')==Mage::registry('current_user')->getId()) {
    		try {
    			$item->delete();
    		} catch (Exception $e) {
    			$data['succeed'] = false;
    			$res['msg'] = "请求出错，请刷新后重试。";
    		}
    	} else {
    		$res['succeed'] = false;
    		$res['msg'] = "无效请求，请刷新后重试。";
    	}
    	echo json_encode($res);
    }
    public function moveModuleAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
			'msg' => '',
		);
    	$linkAId = (int)$this->getRequest()->getParam('link_id_a');
    	$linkBId = (int)$this->getRequest()->getParam('link_id_b');
    	$linkAOrder = (int)$this->getRequest()->getParam('link_order_a');
    	$linkBOrder = (int)$this->getRequest()->getParam('link_order_b');
    	
    	$linkA = Mage::getModel('edm/company_template_module_link')->load($linkAId);
    	$linkB = Mage::getModel('edm/company_template_module_link')->load($linkBId);
    	$templateA = Mage::getModel('edm/company_template')->load($linkA->getLinkTemplate());
    	$templateB = Mage::getModel('edm/company_template')->load($linkB->getLinkTemplate());
    	if ($linkAId && $linkBId && $linkAOrder && $templateB &&
    		$templateA->getData('template_company') == $this->_getCompanyId() && 
    		$templateA->getData('template_create')==Mage::registry('current_user')->getId() &&
    		$templateB->getData('template_company') == $this->_getCompanyId() && 
    		$templateB->getData('template_create')==Mage::registry('current_user')->getId() ) {
    		try {
    			$linkA->setData('link_order',$linkAOrder)->save();
    			$linkB->setData('link_order',$linkBOrder)->save();
    		} catch (Exception $e) {
    			$data['succeed'] = false;
    			$res['msg'] = "请求出错，请刷新后重试。";
    		}
    		
    	} else {
    		$res['succeed'] = false;
    		$res['msg'] = "无效请求，请刷新后重试。";
    	}
    	echo json_encode($res);
    }
    
    /***
     * 保存Item
     */
    public function saveItemAction() {
    	$res = array(
			'succeed'=>true,
			'code' => -1,
			'data' => null,
			'msg' => '',
		);
    	$templateId = (int)$this->getRequest()->getParam('id');
    	$itemId = (int)$this->getRequest()->getParam('item_id',0);
    	$itemContent = trim($this->getRequest()->getParam('item_content'));
		$linkId = (int)$this->getRequest()->getParam('link_id',0);
    	$template = Mage::getModel('edm/company_template')->load($templateId);
    	
    	if ($template->getId() && $itemContent && $linkId) {
    		if ($template->getData('template_company') != $this->_getCompanyId() || $template->getData('template_create')!=Mage::registry('current_user')->getId()) {
    			$data['succeed'] = false;
    			$res['msg'] = "权限不足，请确认。";
    		} else {
    			$item = Mage::getModel('edm/company_template_module_item');
				if ($itemId) {
					$item->load($itemId);
				}
				//已关联
				
				$itemData = array(
					'item_content'=>$itemContent,
					'item_status'=>1,
					'item_link'=>$linkId,
					);
				
				$item->addData($itemData);
				try {
					$item->save();
				} catch (Exception $e) {
					$data['succeed'] = false;
					break;
				}
    			
    			
    		}
    	} else {
    		$data['succeed'] = false;
    		$res['msg'] = "无效请求，请刷新后重试。";
    	}
    	echo json_encode($res);
    }
}

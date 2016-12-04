<?php
class Mage_Adminhtml_Edm_SendController extends Mage_Adminhtml_Controller_Edm
{
	public function newAction() {
		$this->loadLayout();
		$this->_title("邮件")->_title("给客户发邮件");
		$this->_setActiveMenu('edm/email/send_new');
        Mage::helper('edm/company_init')->initDefaultTemplate(Mage::registry('current_company'));
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_send_new', 'send.new'));
		$this->renderLayout();
	}
	public function indexAction() {
		$this->loadLayout();
		$this->_title("邮件")->_title("给客户发邮件");
		$this->_setActiveMenu('edm/email/send_new');
		$stid = $this->getRequest()->getParam('stid',0);
		$sceneId = $this->getRequest()->getParam('scene_id',0);
		if ($stid) {
			$template = Mage::getModel('edm/template')->load($stid);
			$template->setData('is_system',true);
			Mage::register('current_template',$template);
		}
		
		$scene = Mage::getModel('edm/template_scene')->load($sceneId);
		if (!$scene->getId()) {
			$this->_getSession()->addError("请先选择场景。");
			$this->_redirect('*/*/new');
			return;
		}
		
		Mage::register('current_scene',$scene);
		
        Mage::helper('edm/company_init')->initDefaultTemplate(Mage::registry('current_company'));
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_send_edit', 'send.edit'));
		$this->renderLayout();
	}
	
	
	
	public function renderAction() {
		$templateId = $this->getRequest()->getParam('template_id',0);
		$isSystem = $this->getRequest()->getParam('template_system',0);
		if ($isSystem) {
			$template = Mage::getModel('edm/template')->load($templateId);
			$scene = $template->getData('template_scene');
			if ($scene==Mage_Edm_Model_Template_Scene::SCENE_DEVELOP) {
				$this->getSystemDevelopTemplate($template);
			}
			
		} else {
			
		}
	}
	/***
	 * 获取渲染后的邮件
	 */
	public function getSystemDevelopTemplate($template) {
		$templateId = $template->getId();
		$email = $this->getRequest()->getParam('email',false);
		$productNamesPromo = $this->getRequest()->getParam('product_promo','');
		$user = Mage::getSingleton('admin/session')->getUser();
		$company = Mage::registry('current_company');
		$res = array('ret'=>-1,'msg'=>'');
		if (true) {
			$clientHelper = Mage::helper('edm/front_client');
			$client = $clientHelper->getClientByEmail($email);
			if (!$client || !$client->getId()) {
				$client = new Varien_Object();
			}
			Mage::register('current_template',$template);
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
			$output = Mage::getBlockSingleton('adminhtml/template')
				->setTemplate('edm/ajax/email/scene/systemdevelop.phtml')->toHtml();
			$output = $output;
			$res['data'] = $output;
			$res['client_id'] = $client->getId();
			$res['ret'] = 1;
		}
			
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));	
	}
	
	
	
    protected function _isAllowed()
    {
        //return Mage::getSingleton('admin/session')->isAllowed('email');
        return true;
    }
}

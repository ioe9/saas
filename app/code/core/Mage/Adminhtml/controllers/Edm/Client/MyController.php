<?php
class Mage_Adminhtml_Edm_Client_MyController extends Mage_Adminhtml_Controller_Edm {
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('client');
		$this->_title("我的客户列表 - 客户");
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_client_my', 'client.my'));
		$this->renderLayout();
	}
	public function newAction() {
		$this->loadLayout();
		$this->_setActiveMenu('client');

        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_urlprocess_edit', 'urlprocess.edit'));
		$this->renderLayout();
	}
	public function saveAction() {
		$urls = $this->getRequest()->getParam('urls','');
		$data = $this->getRequest()->getParams();
		$position = $this->getRequest()->getParam('position',0);
		$company = Mage::registry('current_company');
		
		if (!$company || !$company->getId()) {
			$this->_getSession()->addError('对不起，会员帐号无效，请联系客服');
			$this->_redirect('*/*/index');
			return;
		}
		$urlArr = explode("\n",trim($urls));
		$i=$j=0;
		
		foreach ($urlArr as $_url) {
			if ($_url = Mage::helper('edm/front_base')->formatUrl($_url)) {
				$model = Mage::getModel('edm/urlprocess');
				$urlData = array(
					'url'=>$_url,
					'company_id'=>$company->getId(),
					'position' => $position,
					
				);
				$data['is_active'] = 1;
				$urlData = array_merge($data,$urlData);
				try {
					$model->addData($urlData)->save();
					$i++;
				} catch (Exception $e) {
					$j++;
				}
			}
		}
		if ($i>0) {
			$this->_getSession()->addSuccess('保存成功'.$i.'条记录');
		}
		if ($j>0) {
			$this->_getSession()->addError('保存失败'.$i.'条记录');
		}
		$this->_redirect('*/*/index');
	}
	

    
	public function _isAllowed() {
    	return true;
	}
}
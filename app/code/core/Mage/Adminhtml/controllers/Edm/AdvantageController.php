<?php
class Mage_Adminhtml_Edm_AdvantageController extends Mage_Adminhtml_Controller_Edm {
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('account');
		$this->_title("帐号设置")->_title("公司优势设置");
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_advantage', 'advantage'));
		$this->renderLayout();
	}
	
	public function saveAction() {
		
		$data = $this->getRequest()->getParams();
		
		$company = Mage::registry('current_company');
		//保存公司优势
		$advantage = $data['advantage'];
		$advantageimg = $data['advantageimg'];
		//echo "<xmp>";var_dump($data); echo "</xmp>";die();
		foreach ($advantage as $_k => $_v) {
			$advantageModel = Mage::getModel('edm/company_advantage')->load($_k);
			$advantageType = $advantageModel->getAdvantageType();
			/*if ($advantageType!='multiselect') {
				$value = Mage::getResourceModel('edm/company_advantage_value_collection')
					->addFieldToFilter('advantage_id',$_k)
					->addFieldToFilter('company_id',$company->getId())
					->getFirstItem();
				if (!$value->getId()) {
					$value->setAdvantageId($_k)
						->setCompanyId($company->getId());
				}
				$value->setValue($_v)->save();
			} else {
			*/
			$values = Mage::getResourceModel('edm/company_advantage_value_collection')
				->addFieldToFilter('advantage_id',$_k)
				->addFieldToFilter('company_id',$company->getId());
			$oldValues = array();
			foreach ($values as $_tv) {
				array_push($oldValues,$_tv['value']);
			}
			$_v = (array)$_v;
			foreach ($_v as $_vv) {
				
				if ($_vv && !in_array($_vv,$oldValues)) {
					Mage::getModel('edm/company_advantage_value')
						->setData('advantage_id',$_k)
						->setData('company_id',$company->getId())
						->setData('value',$_vv)
						->save();
				}
			}
			$companyDelValues = array_diff($oldValues,$_v);	
			$companyDels = Mage::getResourceModel('edm/company_advantage_value_collection')
				->addFieldToFilter('company_id',$company->getId())
				->addFieldToFilter('advantage_id',$_k)
				->addFieldToFilter('value',array('in'=>$companyDelValues));
			foreach ($companyDels as $_companyValue) {
				$_del = Mage::getModel('edm/company_advantage_value')->load($_companyValue->getId());
				$_del->delete();
			}
			//}
		}
		$this->_getSession()->addSuccess('公司优势更新成功！');
		$this->_redirect('*/*/index');
	}
	
	
	
	public function catAction() {
		$this->loadLayout();
		$this->_setActiveMenu('account');
		$this->_title("帐号设置")->_title("基本信息");
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_info_cat', 'info.cat'));
		$this->renderLayout();
	}
    
	public function _isAllowed() {
    	return true;
	}
}
<?php
/***
 * 应用设置-公司优势设置
 */
class Mage_Adminhtml_Edm_Setting_AdvantageController extends Mage_Adminhtml_Controller_Edm {
	public function indexAction() {
		$this->loadLayout();
		$this->_setActiveMenu('setting/advantage');
		$this->_title("应用设置")->_title("公司优势设置");
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_setting_advantage', 'advantage'));
		$this->renderLayout();
	}
	public function newAction() {
		$this->_forward("edit");
	}
	public function editAction() {
		$groupId = (int)$this->getRequest()->getParam('id');
    	$this->loadLayout();
    	$this->_title("应用设置")->_title("公司优势设置");
		$group = Mage::getModel('edm/company_advantage_group')->load($groupId);
		Mage::register('current_group',$group);
        $this->_setActiveMenu('setting/advantage');
        $this->_addContent($this->getLayout()->createBlock('edm/adminhtml_setting_advantage_edit', 'advantage.edit'));
        $this->renderLayout();
	}
	public function itemAction() {
		$this->loadLayout();
		$this->_setActiveMenu('setting/advantage');
		$groupId = (int)$this->getRequest()->getParam('id');
		$this->_title("应用设置")->_title("公司优势设置");
		$group = Mage::getModel('edm/company_advantage_group')->load($groupId);
		Mage::register('current_group',$group);
		$this->_addContent($this->getLayout()->createBlock('edm/adminhtml_setting_advantage_edit_item', 'advantage.edit.item'));
		$this->renderLayout();
	}
	
	public function saveAction() {
		$data = $this->getRequest()->getParams();
		$group = Mage::getModel('edm/company_advantage_group');
		
		if (isset($data['id']) && $data['id']) {
			$group->load($data['id']);
			if ($group->getData('group_company')!=$this->_getCompanyId()) {
				$this->_getSession()->addError("非法操作，你的行为已被记录。");
				$this->_redirect('*/*/index');
				return;
			}
		} else {
			$isNew = true;
		}
		unset($data['id']); 
		$data['group_company'] = $this->_getCompanyId();
		$data['group_create'] = $this->_getUser()->getId();
		$group->addData($data);
		try {
			$group->save();
			$this->_getSession()->addSuccess('信息保存成功');
		} catch (Exception $e) {
			$this->_getSession()->addError("信息保存失败，请重试或联系管理员");
		}
		if ($group->getData('group_type')==0) {
			$this->_redirect('*/*/item',array('id'=>$group->getId()));
		} else {
			$this->_redirect('*/*/index');
		}
		
		
	}
	public function saveItemAction() {
		
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
    
	public function _isAllowed() {
    	return true;
	}
}
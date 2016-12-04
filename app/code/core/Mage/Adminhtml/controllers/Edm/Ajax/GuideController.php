<?php
/**
 * 向导操作
 */
class Mage_Adminhtml_Edm_Ajax_GuideController extends Mage_Adminhtml_Controller_Edm
{	
	public function savecompanyAction() {
		$data = $this->getRequest()->getParam('company');
		$res = array('ret'=>-1,'msg'=>'');
		$company = Mage::registry('current_company');
		
		$company->addData($data)->save();
		$res['ret'] = 1;
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));
	}
	
	public function saveadvantageAction() {
		$data = $this->getRequest()->getParams();
		$res = array('ret'=>-1,'msg'=>'');
		$company = Mage::registry('current_company');
		//保存公司优势
		$advantage = $data['advantage'];
		$advantageimg = $data['advantageimg'];
		
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
		
		$res['ret'] = 1;
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));
	}
	

	
	public function finishsearchAction() {
		$user = Mage::getSingleton('admin/session')->getUser();
		$_SESSION['status_guide_email'] = 1;
		$user = Mage::getModel('admin/user')->load($user->getId())
		->setData('status_guide_email',1)
		->save();
		
	}
	
    protected function _isAllowed()
    {
        //return Mage::getSingleton('admin/session')->isAllowed('email');
        return true;
    }
}

<?php
class Mage_Adminhtml_Edm_Ajax_CompanyController extends Mage_Adminhtml_Controller_Edm
{
	
	public function saveAction() {
		$data = $this->getRequest()->getParams();
		$user = Mage::getSingleton('admin/session')->getUser();
		$company = Mage::registry('current_company');
		if (!$company || !$company->getId()) {
			$this->getResponse()->setBody(Varien_Json::encode(array('ret'=>-1,'msg'=>'对不起，会员帐号无效，请联系客服')));
			return;
		}
		$company->addData($data);
		try {
			$company->save();
			//保存产品分类
			$cats = Mage::getResourceModel('edm/company_category_collection')
					->addFieldToFilter('company_id',$company->getId());
			
			$catOldIds = array();
			foreach ($cats as $_cat) {
				array_push($catOldIds,$_cat->getCategoryId());
			}
			$data['category_a'] = (array)$data['category_a'];
			$data['category_b'] = (array)$data['category_b'];
			
			$catData = array_merge($data['category_a'],(array)$data['category_b']);
			foreach ($catData as $_cid) {
				if ($_cid && !in_array($_cid,$catOldIds)) {
					//insert 
					$cats = Mage::getModel('edm/company_category')
						->setData('company_id',$company->getId())
						->setData('category_id',$_cid)
						->save();
				}
			}
			$catDelIds = array_diff($catOldIds,$catData);	
			$catDels = Mage::getResourceModel('edm/company_category_collection')
						->addFieldToFilter('company_id',$company->getId())
						->addFieldToFilter('category_id',array('in'=>$catDelIds));
			//var_dump($catDelIds);die();				
			foreach ($catDels as $_catDels) {
				$_delId = Mage::getModel('edm/company_category')->load($_catDels->getId());
				$_delId->delete();
			}
			//保存客户自定义属性
			$attr = $data['attr'];
			foreach ($attr as $_k=>$_v) {
				$value = Mage::getResourceModel('edm/company_attr_value_collection')
					->addFieldToFilter('attr_id',$_k)
					->addFieldToFilter('company_id',$company->getId())
					->getFirstItem();
				if (!$value->getId()) {
					$value->setAttrId($_k)
						->setCompanyId($company->getId());
				}
				$value->setValue($_v)->save();
			}
			$this->getResponse()->setBody(Varien_Json::encode(array('ret'=>1,'msg'=>'保存成功')));
		} catch (Exception $e) {
			$this->getResponse()->setBody(Varien_Json::encode(array('ret'=>-1,'msg'=>'对不起，保存失败，请联系客服')));
			return;
			
		}
		

	}
	
	public function getcategoriesAction() {
		$term = trim($this->getRequest()->getParam('term'));
		$categories = Mage::getResourceModel('edm/product_category_collection')
			->addFieldToFilter('name',array('like'=>'%'.$term.'%'));
		$arr = array();
		foreach ($categories as $_cat) {
			array_push($arr,array('id'=>$_cat->getName(),'label'=>$_cat->getName(),'value'=>$_cat->getName()));
		}
		$this->getResponse()->setBody(Varien_Json::encode($arr));
	}
	
    protected function _isAllowed()
    {
        //return Mage::getSingleton('admin/session')->isAllowed('email');
        return true;
    }
}

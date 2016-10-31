<?php
/***
 * 前台会员相关Helper
 */
class Mage_Edm_Helper_Front_Company extends Mage_Core_Helper_Abstract
{
	/***
	 * 初始化Sample数据
	 */
	public function addSampleData($company)
	{
		$sampleId = 1;
		$sampleCompany = Mage::getModel('edm/company')->load($sampleId);
		$arrKey = array('contact_person','name','website','about','guide_status');
		 //新建一个公司，试用sample数据更新
		$sampleData = array();
		$data = $sampleCompany->getData();
		foreach ($data as $_k=>$_v) {
			if (in_array($_k,$arrKey)) {
				$sampleData[$_k] = $_v;
			}
		}
        $company = $company->load($company->getId());
       	$company->addData($sampleData)->save();
       	
       	//初始化行业和产品
       	$categoryRelate = Mage::getResourceModel('edm/company_category_collection')
       		->addFieldToFilter('company_id',$sampleId);
   		foreach ($categoryRelate as $_relate) {
   			$relateModel = Mage::getModel('edm/company_category');
   			$relateModel->setData('company_id',$company->getId())
   				->setData('category_id',$_relate->getData('category_id'))
   				->save();
   				
   		}
   		
   		//初始化优势
   		$categoryRelate = Mage::getResourceModel('edm/company_advantage_value_collection')
       		->addFieldToFilter('company_id',$sampleId);
   		foreach ($categoryRelate as $_relate) {
   			$relateModel = Mage::getModel('edm/company_advantage_value');
   			$relateModel->setData('company_id',$company->getId())
   				->setData('advantage_id',$_relate->getData('advantage_id'))
   				->setData('value',$_relate->getData('value'))
   				->save();
   		}
   		return true;
	}
	
	public function getSubCategoriesNames($company) {
		$cats = Mage::getResourceModel('edm/company_category_collection')
				->addFieldToFilter('company_id',$company->getId());	
		$cats->getSelect()->join(array('p'=>'edm_product_category'),'p.category_id=main_table.category_id',array('level','name'));
		$cats->addFieldToFilter('level',2);
		$arr = array();
		foreach ($cats as $_cat) {
			array_push($arr,$_cat->getData('name'));
		}
		return $arr;
	}
}

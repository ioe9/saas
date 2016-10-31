<?php
/***
 * 公司初始化相关
 */
class Mage_Edm_Helper_Company_Init extends Mage_Core_Helper_Abstract
{
	protected $_defaultTemplateId = 1;
    public function initCompany($company) {
    	$this->initDefaultTemplate($company);
    }
    
    /**
     * 初始化模版
     */
    public function initDefaultTemplate($company) {
    	$template = Mage::getResourceModel('edm/company_template_collection')
    		->addFieldToFilter('template_company',$company->getId())
    		->getFirstItem();
		//尚未有默认模版
		if (!$template->getId()) {
			$companyId =  $company->getId();
			$templateModel = Mage::getModel('edm/company_template');
			$defaultTemplateId = $this->_defaultTemplateId;
			$defaultTemplate = Mage::getModel('edm/templates')->load($defaultTemplateId);
			$templateBody = $defaultTemplate->getData('htmlbody');
			$data = array(
				'template_company' => $companyId,
				'template_name' => '系统默认模版',
				'template_body' => $templateBody,
				'template_parent' => 0,
			);
			try {
				$templateModel->addData($data)->save();
				$newTemplateId = $templateModel->getId();
				$coreResource = Mage::getSingleton('core/resource');
				$conn = $coreResource->getConnection('core_write');
				
				//保存模块
				$templateBody = '[[邮件标题]]'.$templateBody;
				if(preg_match_all(Mage_Edm_Helper_Template::PATTERN_MODULE, $templateBody, $constructions, PREG_SET_ORDER)) {
					//var_dump($constructions);
					foreach($constructions as $index=>$construction) {
						//$construction[0]=="[[公司优势]]"
						$moduleName = trim(str_replace(array('[[',']]'),'',$construction[0]));
						//echo $moduleName.'<br/>';
						
						$moduleModel = Mage::getResourceModel('edm/templates_module_collection')
							->addFieldToFilter('name',$moduleName)
							->addFieldToFilter('template',$defaultTemplate->getId())
							->getFirstItem();
						$oldModuleId = $moduleModel->getId();
						$newModule = Mage::getModel('edm/company_template_module');
						$newData = array(
							'module_name'=> $moduleName,
							'module_template'=> $templateModel->getId(),
							'module_company'=> $companyId,
							'status' => '1',
						);
						
						$newModule->addData($newData)->save();
						
						$newModuleId = $newModule->getId();
						$sql = "INSERT INTO edm_company_template_module_item(`item_module`,`item_parent`,`item_company`,`item_template`,`item_content`,`status`) SELECT '$newModuleId',`item_id`,'$companyId','$newTemplateId',`item_content`,'1' FROM edm_templates_module_item where `module_id`='$oldModuleId' and `status`='1'";
						
						$conn->query($sql);
						
						
						
					}
				}
				/******************* 模块项跟变量客户实行关联关系 应用父Item的关系 ********************/
						
			} catch (Exception $e) {
				
			}
		}
    }
}

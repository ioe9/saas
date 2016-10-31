<?php
/**
 * 模版相关操作
 */
class Mage_Adminhtml_Edm_Ajax_TemplateController extends Mage_Adminhtml_Controller_Edm
{
	public function saveastemplateAction() {
		//模版名称
		$templateName = $this->getRequest()->getParam('template_name','');
		$templateId = $this->getRequest()->getParam('template_id','');
		
		$res = array('ret'=>-1,'msg'=>'');
		if ($templateName && $templateId) {
			$templateModel = Mage::getModel('edm/company_template');
			$data = array(
				'template_company' => Mage::registry('current_company')->getId(),
				'template_user' => Mage::getSingleton('admin/session')->getUser()->getId(),
				'template_name' => $templateName,
				'template_parent' => $templateId,
			);
			try {
				$templateModel->addData($data)->save();
				$newTemplateId = $templateModel->getId();
				//COPY Item数据
				$coreResource = Mage::getSingleton('core/resource');
				$conn = $coreResource->getConnection('core_write');
				$sql = "INSERT INTO ins_company_template_module_item(`item_module`,`item_company`,`item_template`,`item_content`,`status`) SELECT `item_module`,`item_company`,'$newTemplateId',`item_content`,`status` FROM ins_company_template_module_item where `item_template`='$templateId'";
				$conn->query($sql);
				$res['ret'] = 1;
				
			} catch (Exception $e) {
				
				$res['msg'] = "模版保存失败，请联系管理员";
			}
				
				
		} else {
			$res['msg'] = "邮件标题或内容不能同时为空";
		}
			
			
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));
	}
	

	
	
    protected function _isAllowed()
    {
        //return Mage::getSingleton('admin/session')->isAllowed('email');
        return true;
    }
}

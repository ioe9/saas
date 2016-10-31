<?php
class Mage_Edm_AffController extends Mage_Core_Controller_Front_Action
{

	public function ajaxcheckAction() {
	
		$affCode = trim($this->getRequest()->getParam('aff_code'));
		
		$res = array('ret'=>-1,'msg'=>'');
		if ($affCode) {
			$aff = Mage::getResourceModel('edm/aff_collection')
				->addFieldToFilter('aff_code',$affCode)
				->getFirstItem();
			if ($aff->getId()) {
				if ($aff->getData('status')==1) {
					$countLimit = $aff->getData('count_limit');
					$countUsed = $aff->getData('count_used');
					if ($countLimit>0) {
						if ($countUsed>=$countLimit) {
							$res['ret'] = 0;
							$res['ms'] = "邀请码已经超过最大限制试用次数。";
						} else {
							$res['ret'] = 1;
						}
					} else {
						$res['ret'] = 1;
					}
				} else {
					$res['ret'] = 0;
					$res['ms'] = "邀请码未启用";
				}
			} else {
				$res['ret'] = 0;
				$res['ms'] = "邀请码无效";
			}
		}
			
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));
	}
}

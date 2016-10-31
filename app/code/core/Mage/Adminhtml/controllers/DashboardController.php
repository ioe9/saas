<?php
class Mage_Adminhtml_DashboardController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
    	//$this->_redirect('adminhtml/email/new');
    	//return;	
        $this->_title($this->__('Dashboard'));

        $this->loadLayout();
        $this->_setActiveMenu('dashboard');
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Dashboard'), Mage::helper('adminhtml')->__('Dashboard'));
        $this->renderLayout();
    }

    /**
     * Gets most viewed products list
     *
     */
    public function productsViewedAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Gets latest customers list
     *
     */
    public function customersNewestAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Gets the list of most active customers
     *
     */
    public function customersMostAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function ajaxBlockAction()
    {
        $output   = '';
        $blockTab = $this->getRequest()->getParam('block');
        if (in_array($blockTab, array('tab_orders', 'tab_amounts', 'totals'))) {
            $output = $this->getLayout()->createBlock('adminhtml/dashboard_' . $blockTab)->toHtml();
        }
        $this->getResponse()->setBody($output);
        return;
    }

    public function tunnelAction()
    {
        $httpClient = new Varien_Http_Client();
        $gaData = $this->getRequest()->getParam('ga');
        $gaHash = $this->getRequest()->getParam('h');
        if ($gaData && $gaHash) {
            $newHash = Mage::helper('adminhtml/dashboard_data')->getChartDataHash($gaData);
            if ($newHash == $gaHash) {
                $params = json_decode(base64_decode(urldecode($gaData)), true);
                if ($params) {
                    $response = $httpClient->setUri(Mage_Adminhtml_Block_Dashboard_Graph::API_URL)
                            ->setParameterGet($params)
                            ->setConfig(array('timeout' => 5))
                            ->request('GET');

                    $headers = $response->getHeaders();

                    $this->getResponse()
                        ->setHeader('Content-type', $headers['Content-type'])
                        ->setBody($response->getBody());
                }
            }
        }
    }

	public function saveadvantageAction() {
		$data = $this->getRequest()->getParams();
		
		$company = Mage::registry('current_company');
		//保存公司优势
		$advantage = $data['advantage'];
		$advantageimg = $data['advantageimg'];
		
		foreach ($advantage as $_k => $_v) {
			$advantageModel = Mage::getModel('ins/company_advantage')->load($_k);
			$advantageType = $advantageModel->getAdvantageType();
			/*if ($advantageType!='multiselect') {
				$value = Mage::getResourceModel('ins/company_advantage_value_collection')
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
			$values = Mage::getResourceModel('ins/company_advantage_value_collection')
				->addFieldToFilter('advantage_id',$_k)
				->addFieldToFilter('company_id',$company->getId());
			$oldValues = array();
			foreach ($values as $_tv) {
				array_push($oldValues,$_tv['value']);
			}
			$_v = (array)$_v;
			foreach ($_v as $_vv) {
				
				if ($_vv && !in_array($_vv,$oldValues)) {
					Mage::getModel('ins/company_advantage_value')
						->setData('advantage_id',$_k)
						->setData('company_id',$company->getId())
						->setData('value',$_vv)
						->save();
				}
			}
			$companyDelValues = array_diff($oldValues,$_v);	
			$companyDels = Mage::getResourceModel('ins/company_advantage_value_collection')
				->addFieldToFilter('company_id',$company->getId())
				->addFieldToFilter('advantage_id',$_k)
				->addFieldToFilter('value',array('in'=>$companyDelValues));
			foreach ($companyDels as $_companyValue) {
				$_del = Mage::getModel('ins/company_advantage_value')->load($_companyValue->getId());
				$_del->delete();
			}
			//}
		}
			
		//
		//更新向导状态，跳转到开发信界面
		$company->setData('guide_status',1)->save();
		$this->_redirect('adminhtml/dashboard/success');
		//$this->_redirect('adminhtml/email/new');
		
	}
	
	
	public function guidesuccessAction()
    {
    	
        $this->_title($this->__('设置向导'))->_title('帐号信息设置成功');

        $this->loadLayout();
        $this->_setActiveMenu('dashboard');
       
        $this->renderLayout();
    }
    
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('dashboard');
    }
}

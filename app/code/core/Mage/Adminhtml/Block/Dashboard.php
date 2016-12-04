<?php


class Mage_Adminhtml_Block_Dashboard extends Mage_Adminhtml_Block_Template
{
    protected $_locale;

    /**
     * Location of the "Enable Chart" config param
     */
    const XML_PATH_ENABLE_CHARTS = 'admin/dashboard/enable_charts';

    public function __construct()
    {
        parent::__construct();
        //判断是否设置个人信息
        $company = Mage::registry('current_company');
        if ($company->getData('guide_status')) {
        	$this->setTemplate('dashboard/index.phtml');
        } else {
        	$this->setTemplate('dashboard/guide.phtml');
        }
        

    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }

    public function getSwitchUrl()
    {
        if ($url = $this->getData('switch_url')) {
            return $url;
        }
        return $this->getUrl('*/*/*', array('_current'=>true, 'period'=>null));
    }
}

<?php
class Mage_Adminhtml_Controller_Edm extends Mage_Adminhtml_Controller_Action
{
	public function preDispatch() {
		$app = new Varien_Object();
        $app->setName("EDM");
        $app->setCode("edm");
        Mage::register("current_app",$app,true);
        parent::preDispatch();
        if (Mage::registry("current_company")) {
        	$edmCompany = Mage::getModel("edm/company")->loadByCompany($this->_getCompanyId());
			Mage::register("current_edm_company",$edmCompany,true);
        }
        return $this;
	}
		
    protected function _setActiveMenu($menuPath)
    {
    	if (strpos($menuPath,"edm")!==0) {
    		$menuPath = "edm/".$menuPath;
    	}
    	$this->getLayout()->getBlock("navigation")->setActive($menuPath);
        $this->getLayout()->getBlock("menu")->setActive($menuPath);
        return $this;
    }
    
    protected function _isAllowed()
    {
        return Mage::getSingleton("admin/session")->isAllowed("edm");
    }
}

<?php
/***
 * 
 */
class Mage_Adminhtml_Controller_Live extends Mage_Adminhtml_Controller_Action
{
	public function preDispatch() {
		$app = new Varien_Object();
        $app->setName("直播");
        $app->setCode("live");
        Mage::register("current_app",$app,true);
        parent::preDispatch();
        return $this;
	}
		
    protected function _setActiveMenu($menuPath)
    {
    	if (strpos($menuPath,"live")!==0) {
    		$menuPath = "live/".$menuPath;
    	}
    	$this->getLayout()->getBlock("navigation")->setActive($menuPath);
        $this->getLayout()->getBlock("menu")->setActive($menuPath);
        return $this;
    }
    
    protected function _isAllowed()
    {
        return Mage::getSingleton("admin/session")->isAllowed("live");
    }
}


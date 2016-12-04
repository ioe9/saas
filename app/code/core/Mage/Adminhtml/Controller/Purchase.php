<?php
/***
 * 
 */
class Mage_Adminhtml_Controller_Purchase extends Mage_Adminhtml_Controller_Action
{
	public function preDispatch() {
		$app = new Varien_Object();
        $app->setName("采购");
        $app->setCode("purchase");
        Mage::register("current_app",$app,true);
        parent::preDispatch();
        return $this;
	}
		
    protected function _setActiveMenu($menuPath)
    {
    	if (strpos($menuPath,"purchase")!==0) {
    		$menuPath = "purchase/".$menuPath;
    	}
    	$this->getLayout()->getBlock("navigation")->setActive($menuPath);
        $this->getLayout()->getBlock("menu")->setActive($menuPath);
        return $this;
    }
    
    protected function _isAllowed()
    {
        return Mage::getSingleton("admin/session")->isAllowed("purchase");
    }
}


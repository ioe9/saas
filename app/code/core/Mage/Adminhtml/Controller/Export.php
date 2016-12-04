<?php
/***
 * 
 */
class Mage_Adminhtml_Controller_Export extends Mage_Adminhtml_Controller_Action
{
	public function preDispatch() {
		$app = new Varien_Object();
        $app->setName("出口业务");
        $app->setCode("export");
        Mage::register("current_app",$app,true);
        parent::preDispatch();
        return $this;
	}
		
    protected function _setActiveMenu($menuPath)
    {
    	if (strpos($menuPath,"export")!==0) {
    		$menuPath = "export/".$menuPath;
    	}
    	$this->getLayout()->getBlock("navigation")->setActive($menuPath);
        $this->getLayout()->getBlock("menu")->setActive($menuPath);
        return $this;
    }
    
    protected function _isAllowed()
    {
        return Mage::getSingleton("admin/session")->isAllowed("export");
    }
}


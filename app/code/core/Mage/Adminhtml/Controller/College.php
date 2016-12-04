<?php
class Mage_Adminhtml_Controller_College extends Mage_Adminhtml_Controller_Action
{
	public function preDispatch() {
		$app = new Varien_Object();
        $app->setName('外贸学院');
        $app->setCode('college');
        Mage::register('current_app',$app,true);
        parent::preDispatch();
        return $this;
	}
		
    protected function _setActiveMenu($menuPath)
    {
    	if (strpos($menuPath,'college')!==0) {
    		$menuPath = 'college/'.$menuPath;
    	}
    	$this->getLayout()->getBlock('navigation')->setActive($menuPath);
        $this->getLayout()->getBlock('menu')->setActive($menuPath);
        return $this;
    }
    
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('college');
    }
}

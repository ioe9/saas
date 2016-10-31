<?php
class Mage_Adminhtml_Controller_Edm extends Mage_Adminhtml_Controller_Action
{
	public function preDispatch() {
		$app = new Varien_Object();
        $app->setName('EDM');
        Mage::register('current_app',$app,true);
        parent::preDispatch();
        return $this;
	}
		
    protected function _setActiveMenu($menuPath)
    {
    	$this->getLayout()->getBlock('navigation')->setActive('edm');
        $this->getLayout()->getBlock('menu')->setActive($menuPath);
        return $this;
    }
    
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('edm');
    }
}

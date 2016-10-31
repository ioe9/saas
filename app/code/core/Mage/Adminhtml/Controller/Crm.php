<?php
class Mage_Adminhtml_Controller_Crm extends Mage_Adminhtml_Controller_Action
{
	public function preDispatch() {
		$app = new Varien_Object();
        $app->setName('CRM');
        Mage::register('current_app',$app,true);
        parent::preDispatch();
        return $this;
	}
		
    protected function _setActiveMenu($menuPath)
    {
    	$this->getLayout()->getBlock('navigation')->setActive('crm');
        $this->getLayout()->getBlock('menu')->setActive($menuPath);
        return $this;
    }
    
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('crm');
    }
}

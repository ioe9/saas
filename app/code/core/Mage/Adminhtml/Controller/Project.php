<?php
class Mage_Adminhtml_Controller_Project extends Mage_Adminhtml_Controller_Action
{
	public function preDispatch() {
		$app = new Varien_Object();
        $app->setName('项目管理');
        Mage::register('current_app',$app,true);
        parent::preDispatch();
        return $this;
	}
		
    protected function _setActiveMenu($menuPath)
    {
    	$this->getLayout()->getBlock('navigation')->setClass('toponly')->setActive('project');
        $this->getLayout()->getBlock('menu')->setActive($menuPath);
        return $this;
    }
    
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('project');
    }
}

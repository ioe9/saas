<?php
class Mage_Adminhtml_Controller_Dashboard extends Mage_Adminhtml_Controller_Action
{
	protected $_appData = array(
		'name' => '工作台',
		'code' => 'dashboard',
	);
	public function preDispatch() {
		$app = new Varien_Object();
        $app->addData($this->_appData);
        Mage::register('current_app',$app,true);
        parent::preDispatch();
        return $this;
	}
		
    protected function _setActiveMenu($menuPath)
    {
    	$this->getLayout()->getBlock('navigation')->setActive('dashboard');
        $this->getLayout()->getBlock('menu')->setActive($menuPath);
        return $this;
    }
    
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('dashboard');
    }
}

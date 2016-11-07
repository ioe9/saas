<?php
/***
 * 系统设置
 */
class Mage_Adminhtml_Controller_Setting extends Mage_Adminhtml_Controller_Action
{
	protected $_appData = array(
		'name' => '系统设置',
		'code' => 'setting',
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
    	$this->getLayout()->getBlock('navigation')->setActive($menuPath);
        $this->getLayout()->getBlock('menu')->setActive($menuPath);
        return $this;
    }
    
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('setting');
    }
}

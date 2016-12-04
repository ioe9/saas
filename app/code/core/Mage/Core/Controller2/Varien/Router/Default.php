<?php
class Mage_Core_Controller_Varien_Router_Default extends Mage_Core_Controller_Varien_Router_Abstract
{
    /**
     * 默认 404
     * @param Varien_Controller_Request_Http $request
     * @return boolean
     */
    public function match(Varien_Controller_Request_Http $request)
    {
       	$noRoute        = explode('/', $this->_getNoRouteConfig());
        $moduleName     = isset($noRoute[0]) && $noRoute[0] ? $noRoute[0] : 'core';
        $controllerName = isset($noRoute[1]) && $noRoute[1] ? $noRoute[1] : 'index';
        $actionName     = isset($noRoute[2]) && $noRoute[2] ? $noRoute[2] : 'index';

        if ($this->_isAdmin()) {
            $adminFrontName = (string)Mage::getConfig()->getNode('admin/routers/adminhtml/args/frontName');
            if ($adminFrontName != $moduleName) {
                $moduleName     = 'core';
                $controllerName = 'index';
                $actionName     = 'noRoute';
            }
        }
		
        $request->setModuleName($moduleName)
            ->setControllerName($controllerName)
            ->setActionName($actionName);
            //->setDispatched(true);

        return true;
    }
    
    protected function _getNoRouteConfig()
    {
        return 'cms/index/noRoute';
    }
    protected function _isAdmin()
    {
        return false;
    }
}

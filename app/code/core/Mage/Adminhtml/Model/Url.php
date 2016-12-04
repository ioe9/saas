<?php

class Mage_Adminhtml_Model_Url extends Mage_Core_Model_Url
{
    /**
     * Secret key query param name
     */
    const SECRET_KEY_PARAM_NAME = 'key';

    /**
     * Retrieve is secure mode for ULR logic
     *
     * @return bool
     */
    public function getSecure()
    {
        if ($this->hasData('secure_is_forced')) {
            return $this->getData('secure');
        }
        return Mage::getStoreConfigFlag('web/secure/use_in_adminhtml');
    }

    /**
     * Force strip secret key param if _nosecret param specified
     *
     * @return Mage_Core_Model_Url
     */
    public function setRouteParams(array $data, $unsetOldParams=true)
    {
        if (isset($data['_nosecret'])) {
            $this->setNoSecret(true);
            unset($data['_nosecret']);
        } else {
            $this->setNoSecret(false);
        }

        return parent::setRouteParams($data, $unsetOldParams);
    }

    /**
     * Custom logic to retrieve Urls
     *
     * @param string $routePath
     * @param array $routeParams
     * @return string
     */
    public function getUrl($routePath=null, $routeParams=null)
    {
        $cacheSecretKey = false;
        if (is_array($routeParams) && isset($routeParams['_cache_secret_key'])) {
            unset($routeParams['_cache_secret_key']);
            $cacheSecretKey = true;
        }
		
        $result = parent::getUrl($routePath, $routeParams);
        //echo $result;die();
        if (!$this->useSecretKey()) {
            return $result;
        }
		
        $_route = $this->getRouteName() ? $this->getRouteName() : '*';
        $_controller = $this->getControllerName() ? $this->getControllerName() : $this->getDefaultControllerName();
        $_action = $this->getActionName() ? $this->getActionName() : $this->getDefaultActionName();

        if ($cacheSecretKey) {
            $secret = array(self::SECRET_KEY_PARAM_NAME => "\${$_controller}/{$_action}\$");
        }
        else {
            $secret = array(self::SECRET_KEY_PARAM_NAME => $this->getSecretKey($_controller, $_action));
        }
        if (is_array($routeParams)) {
            $routeParams = array_merge($secret, $routeParams);
        } else {
            $routeParams = $secret;
        }
        if (is_array($this->getRouteParams())) {
            $routeParams = array_merge($this->getRouteParams(), $routeParams);
        }

        return parent::getUrl("{$_route}/{$_controller}/{$_action}", $routeParams);
    }

    /**
     * Generate secret key for controller and action based on form key
     *
     * @param string $controller Controller name
     * @param string $action Action name
     * @return string
     */
    public function getSecretKey($controller = null, $action = null)
    {
        $salt = Mage::getSingleton('core/session')->getFormKey();

        $p = explode('/', trim($this->getRequest()->getOriginalPathInfo(), '/'));
        if (!$controller) {
            $controller = !empty($p[1]) ? $p[1] : $this->getRequest()->getControllerName();
        }
        if (!$action) {
            $action = !empty($p[2]) ? $p[2] : $this->getRequest()->getActionName();
        }

        $secret = $controller . $action . $salt;
        return Mage::helper('core')->getHash($secret);
    }

    /**
     * Return secret key settings flag
     *
     * @return boolean
     */
    public function useSecretKey()
    {
        return Mage::getStoreConfigFlag('admin/security/use_form_key') && !$this->getNoSecret();
        //return true;
    }

    /**
     * Enable secret key using
     *
     * @return Mage_Adminhtml_Model_Url
     */
    public function turnOnSecretKey()
    {
        $this->setNoSecret(false);
        return $this;
    }

    /**
     * Disable secret key using
     *
     * @return Mage_Adminhtml_Model_Url
     */
    public function turnOffSecretKey()
    {
        $this->setNoSecret(true);
        return $this;
    }

    /**
     * Refresh admin menu cache etc.
     *
     * @return Mage_Adminhtml_Model_Url
     */
    public function renewSecretUrls()
    {
        Mage::app()->cleanCache(array(Mage_Adminhtml_Block_Page_Menu::CACHE_TAGS));
    }
}

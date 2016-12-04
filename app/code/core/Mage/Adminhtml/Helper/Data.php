<?php
/**
 * Adminhtml base helper
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ADMINHTML_ROUTER_FRONTNAME   = 'admin/routers/adminhtml/args/frontName';
    const XML_PATH_USE_CUSTOM_ADMIN_URL         = 'default/admin/url/use_custom';
    const XML_PATH_USE_CUSTOM_ADMIN_PATH        = 'default/admin/url/use_custom_path';
    const XML_PATH_CUSTOM_ADMIN_PATH            = 'default/admin/url/custom_path';

    protected $_pageHelpUrl;

    public function getPageHelpUrl()
    {
        if (!$this->_pageHelpUrl) {
            $this->setPageHelpUrl();
        }
        return $this->_pageHelpUrl;
    }

    public function setPageHelpUrl($url=null)
    {
        if (is_null($url)) {
            $request = Mage::app()->getRequest();
            $frontModule = $request->getControllerModule();
            if (!$frontModule) {
                $frontName = $request->getModuleName();
                $router = Mage::app()->getFrontController()->getRouterByFrontName($frontName);

                $frontModule = $router->getModuleByFrontName($frontName);
                if (is_array($frontModule)) {
                    $frontModule = $frontModule[0];
                }
            }
            $url = 'http://www.magentocommerce.com/gethelp/';
            $url.= 'zh_CN_'.'/';
            $url.= $frontModule.'/';
            $url.= $request->getControllerName().'/';
            $url.= $request->getActionName().'/';

            $this->_pageHelpUrl = $url;
        }
        $this->_pageHelpUrl = $url;

        return $this;
    }

    public function addPageHelpUrl($suffix)
    {
        $this->_pageHelpUrl = $this->getPageHelpUrl().$suffix;
        return $this;
    }

    public static function getUrl($route='', $params=array())
    {
        return Mage::getModel('adminhtml/url')->getUrl($route, $params);
    }

//    public function getCurrentUserId()
//    {
//        return Mage::getSingleton('admin/session')->getUser()->getId();
//    }
    public function getCurrentUserId()
    {
        if (Mage::getSingleton('admin/session')->getUser()) {
            return Mage::getSingleton('admin/session')->getUser()->getId();
        }
        return false;
    }

    /**
     * Decode filter string
     *
     * @param string $filterString
     * @return data
     */
    public function prepareFilterString($filterString)
    {
        $data = array();
        $filterString = base64_decode($filterString);
        parse_str($filterString, $data);
        array_walk_recursive($data, array($this, 'decodeFilter'));
        return $data;
    }

    /**
     * Decode URL encoded filter value recursive callback method
     *
     * @param string $value
     */
    public function decodeFilter(&$value)
    {
        $value = trim(rawurldecode($value));
    }
}

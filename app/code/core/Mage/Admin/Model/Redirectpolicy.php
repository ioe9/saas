<?php
class Mage_Admin_Model_Redirectpolicy
{
    /**
     * @var Mage_Adminhtml_Model_Url
     */
    protected $_urlModel;

    /**
     * @param array $parameters array('urlModel' => object)
     */
    public function __construct($parameters = array())
    {
        /** @var Mage_Adminhtml_Model_Url _urlModel */
        $this->_urlModel = (!empty($parameters['urlModel'])) ?
            $parameters['urlModel'] : Mage::getModel('adminhtml/url');
    }

    /**
     * Redirect to startup page after logging in if request contains any params (except security key)
     *
     * @param Mage_Admin_Model_User $user
     * @param Zend_Controller_Request_Http $request
     * @param string|null $alternativeUrl
     * @return null|string
     */
    public function getRedirectUrl(Mage_Admin_Model_User $user, Zend_Controller_Request_Http $request = null,
                                $alternativeUrl = null)
    {
        if (empty($request)) {
            return;
        }
        $countRequiredParams = $this->_urlModel->useSecretKey() ? 1 : 0;
        $countGetParams = count($request->getUserParams()) + count($request->getQuery());

        return ($countGetParams > $countRequiredParams) ?
            $this->_urlModel->getUrl($user->getStartupPageUrl()) : $alternativeUrl;
    }
}

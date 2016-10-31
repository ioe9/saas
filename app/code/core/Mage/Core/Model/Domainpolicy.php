<?php
class Mage_Core_Model_Domainpolicy
{
    /**
     * X-Frame-Options allow (header is absent)
     */
    const FRAME_POLICY_ALLOW = 1;

    /**
     * X-Frame-Options SAMEORIGIN
     */
    const FRAME_POLICY_ORIGIN = 2;

    /**
     * Path to backend domain policy settings
     */
    const XML_DOMAIN_POLICY_BACKEND = 'admin/security/domain_policy_backend';

    /**
     * Path to frontend domain policy settings
     */
    const XML_DOMAIN_POLICY_FRONTEND = 'admin/security/domain_policy_frontend';

    /**
     * Current store
     *
     * @var Mage_Core_Model_Store
     */
    protected $_store;

    public function __construct($options = array())
    {
        $this->_store = isset($options['store']) ? $options['store'] : Mage::app()->getStore();
    }

    /**
     * Add X-Frame-Options header to response, depends on config settings
     *
     * @var Varien_Object $observer
     * @return $this
     */
    public function addDomainPolicyHeader($observer)
    {
        /** @var Mage_Core_Controller->getCurrentAreaDomainPolicy_Varien_Action $action */
        $action = $observer->getControllerAction();
        $policy = null;

        if ('adminhtml' == $action->getLayout()->getArea()) {
            $policy = $this->getBackendPolicy();
        } elseif('frontend' == $action->getLayout()->getArea()) {
            $policy = $this->getFrontendPolicy();
        }

        if ($policy) {
            /** @var Mage_Core_Controller_Response_Http $response */
            $response = $action->getResponse();
            $response->setHeader('X-Frame-Options', $policy, true);
        }

        return $this;
    }

    /**
     * Get backend policy
     *
     * @return string|null
     */
    public function getBackendPolicy()
    {
        return $this->_getDomainPolicyByCode((int)(string)Mage::app()->getStoreConfig(self::XML_DOMAIN_POLICY_BACKEND));
    }

    /**
     * Get frontend policy
     *
     * @return string|null
     */
    public function getFrontendPolicy()
    {
        return $this->_getDomainPolicyByCode((int)(string)Mage::app()->getStoreConfig(self::XML_DOMAIN_POLICY_FRONTEND));
    }



    /**
     * Return string representation for policy code
     *
     * @param $policyCode
     * @return string|null
     */
    protected function _getDomainPolicyByCode($policyCode)
    {
        switch($policyCode) {
            case self::FRAME_POLICY_ALLOW:
                $policy = null;
                break;
            default:
                $policy = 'SAMEORIGIN';
        }

        return $policy;
    }
}

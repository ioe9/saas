<?php
class Varien_Acl_Resource implements Varien_Acl_Resource_Interface
{
    /**
     * Unique id of Resource
     *
     * @var string
     */
    protected $_resourceId;

    /**
     * Sets the Resource identifier
     *
     * @param  string $resourceId
     */
    public function __construct($resourceId)
    {
        $this->_resourceId = (string) $resourceId;
    }

    /**
     * Defined by Varien_Acl_Resource_Interface; returns the Resource identifier
     *
     * @return string
     */
    public function getResourceId()
    {
        return $this->_resourceId;
    }

    /**
     * Defined by Varien_Acl_Resource_Interface; returns the Resource identifier
     * Proxies to getResourceId()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getResourceId();
    }
}

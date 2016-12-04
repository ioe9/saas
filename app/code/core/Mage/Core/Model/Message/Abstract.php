<?php
/**
 * Abstract message model
 *
 * @category   Mage
 * @package    Mage_Core
 * @author      Mio Core Team <developer@ioe9.com>
 */
abstract class Mage_Core_Model_Message_Abstract
{
    protected $_type;
    protected $_code;
    protected $_class;
    protected $_method;
    protected $_identifier;
    protected $_isSticky = false;

    public function __construct($type, $code='')
    {
        $this->_type = $type;
        $this->_code = $code;
    }

    public function getCode()
    {
        return $this->_code;
    }

    public function getText()
    {
        return $this->getCode();
    }

    public function getType()
    {
        return $this->_type;
    }

    public function setClass($class)
    {
        $this->_class = $class;
    }

    public function setMethod($method)
    {
        $this->_method = $method;
    }

    public function toString()
    {
        $out = $this->getType().': '.$this->getText();
        return $out;
    }

    /**
     * Set message identifier
     *
     * @param string $id
     * @return Mage_Core_Model_Message_Abstract
     */
    public function setIdentifier($id)
    {
        $this->_identifier = $id;
        return $this;
    }

    /**
     * Get message identifier
     *
     *  @return string
     */
    public function getIdentifier()
    {
        return $this->_identifier;
    }

    /**
     * Set message sticky status
     *
     * @param bool $isSticky
     * @return Mage_Core_Model_Message_Abstract
     */
    public function setIsSticky($isSticky = true)
    {
        $this->_isSticky = $isSticky;
        return $this;
    }

    /**
     * Get whether message is sticky
     *
     * @return bool
     */
    public function getIsSticky()
    {
        return $this->_isSticky;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Mage_Core_Model_Message_Abstract
     */
    public function setCode($code)
    {
        $this->_code = $code;
        return $this;
    }
}

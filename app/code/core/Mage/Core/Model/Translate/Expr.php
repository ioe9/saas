<?php
/**
 * Translate expression object
 *
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Model_Translate_Expr
{
    protected $_text;
    protected $_module;
    
    public function __construct($text='', $module='') 
    {
        $this->_text    = $text;
        $this->_module  = $module;
    }
    
    public function setText($text)
    {
        $this->_text = $text;
        return $this;
    }
    
    public function setModule($module)
    {
        $this->_module = $module;
        return $this;
    }
    
    /**
     * Retrieve expression text
     *
     * @return string
     */
    public function getText()
    {
        return $this->_text;
    }
    
    /**
     * Retrieve expression module
     *
     * @return string
     */
    public function getModule()
    {
        return $this->_module;
    }
    
    /**
     * Retrieve expression code
     *
     * @param   string $separator
     * @return  string
     */
    public function getCode($separator='::')
    {
        return $this->getModule().$separator.$this->getText();
    }
}

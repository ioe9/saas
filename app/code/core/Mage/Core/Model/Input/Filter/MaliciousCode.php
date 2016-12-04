<?php
/**
 * Filter for removing malicious code from HTML
 *
 * @category   Mage
 * @package    Mage_Core
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Model_Input_Filter_MaliciousCode implements Zend_Filter_Interface
{
    /**
     * Regular expressions for cutting malicious code
     *
     * @var array
     */
    protected $_expressions = array(
        //comments, must be first
        '/(\/\*.*\*\/)/Us',
        //tabs
        '/(\t)/',
        //javasript prefix
        '/(javascript\s*:)/Usi',
        //import styles
        '/(@import)/Usi',
        //js in the style attribute
        '/style=[^<]*((expression\s*?\([^<]*?\))|(behavior\s*:))[^<]*(?=\>)/Uis',
        //js attributes
        '/(ondblclick|onclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onload|onunload|onerror)=[^<]*(?=\>)/Uis',
        //tags
        '/<\/?(script|meta|link|frame|iframe).*>/Uis',
        //base64 usage
        '/src=[^<]*base64[^<]*(?=\>)/Uis',
    );

    /**
     * Filter value
     *
     * @param string|array $value
     * @return string|array         Filtered value
     */
    public function filter($value)
    {
        return preg_replace($this->_expressions, '', $value);
    }

    /**
     * Add expression
     *
     * @param string $expression
     * @return Mage_Core_Model_Input_Filter_MaliciousCode
     */
    public function addExpression($expression)
    {
        if (!in_array($expression, $this->_expressions)) {
            $this->_expressions[] = $expression;
        }
        return $this;
    }

    /**
     * Set expressions
     *
     * @param array $expressions
     * @return Mage_Core_Model_Input_Filter_MaliciousCode
     */
    public function setExpressions(array $expressions)
    {
        $this->_expressions = $expressions;
        return $this;
    }
}

<?php
/**
 * Validator for check not protected file extensions
 *
 * @category   Mage
 * @package    Mage_Core
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Model_File_Validator_NotProtectedExtension extends Varien_Validate_Abstract
{
    const PROTECTED_EXTENSION = 'protectedExtension';

    /**
     * The file extension
     *
     * @var string
     */
    protected $_value;

    /**
     * Protected file types
     *
     * @var array
     */
    protected $_protectedFileExtensions = array();

    /**
     * Construct
     */
    public function __construct()
    {
        $this->_initMessageTemplates();
        $this->_initProtectedFileExtensions();
    }

    /**
     * Initialize message templates with translating
     *
     * @return Mage_Core_Model_File_Validator_NotProtectedExtension
     */
    protected function _initMessageTemplates()
    {
        if (!$this->_messageTemplates) {
            $this->_messageTemplates = array(
                self::PROTECTED_EXTENSION => Mage::helper('core')->__('File with an extension "%value%" is protected and cannot be uploaded'),
            );
        }
        return $this;
    }

    /**
     * Initialize protected file extensions
     *
     * @return Mage_Core_Model_File_Validator_NotProtectedExtension
     */
    protected function _initProtectedFileExtensions()
    {
        if (!$this->_protectedFileExtensions) {
            /** @var $helper Mage_Core_Helper_Data */
            $helper = Mage::helper('core');
            $extensions = $helper->getProtectedFileExtensions();
            if (is_string($extensions)) {
                $extensions = explode(',', $extensions);
            }
            foreach ($extensions as &$ext) {
                $ext = strtolower(trim($ext));
            }
            $this->_protectedFileExtensions = (array) $extensions;
        }
        return $this;
    }


    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param string $value         Extension of file
     * @return bool
     */
    public function isValid($value)
    {
        $value = strtolower(trim($value));
        $this->_setValue($value);

        if (in_array($this->_value, $this->_protectedFileExtensions)) {
            $this->_error(self::PROTECTED_EXTENSION, $this->_value);
            return false;
        }

        return true;
    }
}

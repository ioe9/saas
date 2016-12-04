<?php
/**
 * Core file uploader model
 *
 * @category   Mage
 * @package    Mage_Core
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Model_File_Uploader extends Varien_File_Uploader
{
    /**
     * Flag, that defines should DB processing be skipped
     *
     * @var bool
     */
    protected $_skipDbProcessing = false;

    /**
     * Save file to storage
     *
     * @param  array $result
     * @return Mage_Core_Model_File_Uploader
     */
    protected function _afterSave($result)
    {
        if (empty($result['path']) || empty($result['file'])) {
            return $this;
        }

        /** @var $helper Mage_Core_Helper_File_Storage */
        $helper = Mage::helper('core/file_storage');

        if ($helper->isInternalStorage() || $this->skipDbProcessing()) {
            return $this;
        }

        /** @var $dbHelper Mage_Core_Helper_File_Storage_Database */
        $dbHelper = Mage::helper('core/file_storage_database');
        $this->_result['file'] = $dbHelper->saveUploadedFile($result);

        return $this;
    }

    /**
     * Getter/Setter for _skipDbProcessing flag
     *
     * @param null|bool $flag
     * @return bool|Mage_Core_Model_File_Uploader
     */
    public function skipDbProcessing($flag = null)
    {
        if (is_null($flag)) {
            return $this->_skipDbProcessing;
        }
        $this->_skipDbProcessing = (bool)$flag;
        return $this;
    }

    /**
     * Check protected/allowed extension
     *
     * @param string $extension
     * @return boolean
     */
    public function checkAllowedExtension($extension)
    {
        //validate with protected file types
        /** @var $validator Mage_Core_Model_File_Validator_NotProtectedExtension */
        $validator = Mage::getSingleton('core/file_validator_notProtectedExtension');
        if (!$validator->isValid($extension)) {
            return false;
        }

        return parent::checkAllowedExtension($extension);
    }
}

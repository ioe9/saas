<?php
/**
 * Synchronize process status flag class
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Model_File_Storage_Flag extends Mage_Core_Model_Flag
{
    /**
     * There was no synchronization
     */
    const STATE_INACTIVE    = 0;
    /**
     * Synchronize process is active
     */
    const STATE_RUNNING     = 1;
    /**
     * Synchronization finished
     */
    const STATE_FINISHED    = 2;
    /**
     * Synchronization finished and notify message was formed
     */
    const STATE_NOTIFIED    = 3;

    /**
     * Flag time to life in seconds
     */
    const FLAG_TTL          = 300;

    /**
     * Synchronize flag code
     *
     * @var string
     */
    protected $_flagCode    = 'synchronize';

    /**
     * Pass error to flag
     *
     * @param Exception $e
     * @return Mage_Core_Model_File_Storage_Flag
     */
    public function passError(Exception $e)
    {
        $data = $this->getFlagData();
        if (!is_array($data)) {
            $data = array();
        }
        $data['has_errors'] = true;
        $this->setFlagData($data);
        return $this;
    }
}

<?php
class Mage_Core_Model_Logger
{
    /**
     * Log wrapper
     *
     * @param string $message
     * @param int $level
     * @param string $file
     * @param bool $forceLog
     * @return void
     */
    public function log($message, $level = null, $file = '', $forceLog = false)
    {
        Mage::log($message, $level, $file, $forceLog);
    }

    /**
     * Log exception wrapper
     *
     * @param Exception $e
     * @return void
     */
    public function logException(Exception $e)
    {
        Mage::logException($e);
    }
}

<?php
/**
 * Log Adapter
 *
 * @category   Mage
 * @package    Mage_Core
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Model_Log_Adapter
{

    /**
     * Store log file name
     *
     * @var string
     */
    protected $_logFileName = '';

    /**
     * Data to log
     *
     * @var array
     */
    protected $_data = array();

    /**
     * Fields that should be replaced in debug data with '***'
     *
     * @var array
     */
    protected $_debugReplacePrivateDataKeys = array();

    /**
     * Set log file name
     *
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $this->_logFileName = $fileName;
    }

    /**
     * Perform forced log data to file
     *
     * @param mixed $data
     * @return Mage_Core_Model_Log_Adapter
     */
    public function log($data = null)
    {
        if ($data === null) {
            $data = $this->_data;
        }
        else {
            if (!is_array($data)) {
                $data = array($data);
            }
        }
        $data = $this->_filterDebugData($data);
        $data['__pid'] = getmypid();
        Mage::log($data, null, $this->_logFileName, true);
        return $this;
    }

    /**
     * Log data setter
     *
     * @param string|array $key
     * @param mixed $value
     * @return Mage_Core_Model_Log_Adapter
     * @todo replace whole data
     */
    public function setData($key, $value = null)
    {
        if(is_array($key)) {
            $this->_data = $key;
        }
        else {
            $this->_data[$key] = $value;
        }
        return $this;
    }

    /**
     * Setter for private data keys, that should be replaced in debug data with '***'
     *
     * @param array $keys
     * @return Mage_Core_Model_Log_Adapter
     */
    public function setFilterDataKeys($keys)
    {
        if (!is_array($keys)) {
            $keys = array($keys);
        }
        $this->_debugReplacePrivateDataKeys = $keys;
        return $this;
    }

    /**
     * Recursive filter data by private conventions
     *
     * @param mixed $debugData
     * @return mixed
     */
    protected function _filterDebugData($debugData)
    {
        if (is_array($debugData) && is_array($this->_debugReplacePrivateDataKeys)) {
            foreach ($debugData as $key => $value) {
                if (in_array($key, $this->_debugReplacePrivateDataKeys)) {
                    $debugData[$key] = '****';
                }
                else {
                    if (is_array($debugData[$key])) {
                        $debugData[$key] = $this->_filterDebugData($debugData[$key]);
                    }
                }
            }
        }
        return $debugData;
    }
}

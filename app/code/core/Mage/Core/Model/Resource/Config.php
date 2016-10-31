<?php
class Mage_Core_Model_Resource_Config extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Define main table
     *
     */
    protected function _construct()
    {
        $this->_init('core/config_data', 'config_id');
    }

    /**
     * Load configuration values into xml config object
     *
     * @param Mage_Core_Model_Config $xmlConfig
     * @param string $condition
     * @return Mage_Core_Model_Resource_Config
     */
    public function loadToXml(Mage_Core_Model_Config $xmlConfig, $condition = null)
    {
    	
        $read = $this->_getReadAdapter();
        if (!$read) {
            return $this;
        }
        $substFrom = array();
        $substTo   = array();
		
        // load all configuration records from database, which are not inherited
        $select = $read->select()
            ->from($this->getMainTable(), array('path', 'value'));
        if (!is_null($condition)) {
            $select->where($condition);
        }
        
        $rowset = $read->fetchAll($select);
        // set config values from database
        
        foreach ($rowset as $r) {
            $value = str_replace($substFrom, $substTo, $r['value']);
            $nodePath = sprintf('%s', $r['path']);
            $xmlConfig->setNode($nodePath, $value);
        }
        
        return $this;
    }

    /**
     * Save config value
     *
     * @param string $path
     * @param string $value
     * @return Mage_Core_Model_Resource_Config
     */
    public function saveConfig($path, $value, $scope, $scopeId)
    {
        $writeAdapter = $this->_getWriteAdapter();
        $select = $writeAdapter->select()
            ->from($this->getMainTable())
            ->where('path = ?', $path);
        $row = $writeAdapter->fetchRow($select);

        $newData = array(
            'path'      => $path,
            'value'     => $value
        );

        if ($row) {
            $whereCondition = array($this->getIdFieldName() . '=?' => $row[$this->getIdFieldName()]);
            $writeAdapter->update($this->getMainTable(), $newData, $whereCondition);
        } else {
            $writeAdapter->insert($this->getMainTable(), $newData);
        }
        return $this;
    }

    /**
     * Delete config value
     *
     * @param string $path
     * @return Mage_Core_Model_Resource_Config
     */
    public function deleteConfig($path)
    {
        $adapter = $this->_getWriteAdapter();
        $adapter->delete($this->getMainTable(), array(
            $adapter->quoteInto('path = ?', $path),
        ));
        return $this;
    }
}

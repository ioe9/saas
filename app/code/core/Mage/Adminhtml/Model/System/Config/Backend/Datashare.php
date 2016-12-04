<?php
/**
 * Config category field backend
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Model_System_Config_Backend_Datashare extends Mage_Core_Model_Config_Data
{
    protected function _afterSave()
    {
#echo "<pre>".print_r($configData,1)."</pre>"; die;
    }
}

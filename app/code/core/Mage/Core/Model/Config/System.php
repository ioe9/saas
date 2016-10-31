<?php
/***
 * 配置信息
 */
class Mage_Core_Model_Config_System extends Mage_Core_Model_Config_Base
{
    function __construct($sourceData=null)
    {
        parent::__construct($sourceData);
    }

    public function load($module)
    {
        $file = Mage::getConfig()->getModuleDir('etc', $module).DS.'system.xml';
        $this->loadFile($file);
        return $this;
    }
}

<?php
class Mage_Core_Model_Design_Config extends Varien_Simplexml_Config
{
    protected $_designRoot;

    /**
     * Assemble themes inheritance config
     *
     */
    public function __construct(array $params = array())
    {
        if (isset($params['designRoot'])) {
            if (!is_dir($params['designRoot'])) {
                throw new Mage_Core_Exception("Design root '{$params['designRoot']}' isn't a directory.");
            }
            $this->_designRoot = $params['designRoot'];
        } else {
            $this->_designRoot = Mage::getBaseDir('design');
        }
        $this->_cacheChecksum = null;
        $this->setCacheId('config_theme');
        $this->setCache(Mage::app()->getCache());
        if (!$this->loadCache()) {
            $this->loadString('<theme />');
            $path = str_replace('/', DS, $this->_designRoot . '/*/*/*/etc/theme.xml');
            $files = glob($path);
            foreach ($files as $file) {
                $config = new Varien_Simplexml_Config();
                $config->loadFile($file);
                list($area, $package, $theme) = $this->_getThemePathSegments($file);
                $this->setNode($area . '/' . $package . '/' . $theme, null);
                $this->getNode($area . '/' . $package . '/' . $theme)->extend($config->getNode());
            }
            $this->saveCache();
        }
    }

    /**
     * Load cache
     *
     * @return boolean
     */
    public function loadCache()
    {
        if ($this->_canUseCache()) {
            return parent::loadCache();
        }
        return false;
    }

    /**
     * Save cache
     *
     * @param array $tags
     * @return Mage_Core_Model_Design_Config
     */
    public function saveCache($tags = null)
    {
        if ($this->_canUseCache()) {
            $tags = is_array($tags) ? $tags : array();
            if (!in_array(Mage_Core_Model_Config::CACHE_TAG, $tags)) {
                $tags[] = Mage_Core_Model_Config::CACHE_TAG;
            }
            parent::saveCache($tags);
        }
        return $this;
    }

    /**
     * @return bool
     */
    protected function _canUseCache()
    {
        return (bool)Mage::app()->useCache('config');
    }

    /**
     * Get area, package and theme from path .../app/design/{area}/{package}/{theme}/etc/theme.xml
     *
     * @param string $filePath
     * @return array
     */
    protected function _getThemePathSegments($filePath)
    {
        $segments = array_reverse(explode(DS, $filePath));
        return array($segments[4], $segments[3], $segments[2]);
    }
}

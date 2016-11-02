<?php
class Varien_Cache_Core extends Magento_Cache_Core
{
    /**
     * Specific slab size = 1Mb minus overhead
     *
     * @var array $_specificOptions
     */
    protected $_specificOptions = array('slab_size' => 0);

    /**
     * Used to tell chunked data from ordinary
     */
    const CODE_WORD = '{splitted}';

    /**
     * Constructor
     *
     * @throws Varien_Exception
     * @param array|Zend_Config $options Associative array of options or Zend_Config instance
     */
    public function __construct($options = array())
    {
        if (!is_numeric($this->getOption('slab_size'))) {
            throw new Varien_Exception("Invalid value for the node <slab_size>. Expected to be integer.");
        }
    }

    /**
     * Returns ID of a specific chunk on the basis of data's ID
     *
     * @param string $id    Main data's ID
     * @param int    $index Particular chunk number to return ID for
     * @return string
     */
    protected function _getChunkId($id, $index)
    {
        return "{$id}[{$index}]";
    }

    /**
     * Remove saved chunks in case something gone wrong (e.g. some chunk from the chain can not be found)
     *
     * @param string $id     ID of data's info cell
     * @param int    $chunks Number of chunks to remove (basically, the number after '{splitted}|')
     * @return null
     */
    protected function _cleanTheMess($id, $chunks)
    {
        for ($i = 0; $i < $chunks; $i++) {
            $this->remove($this->_getChunkId($id, $i));
        }

        $this->remove($id);
    }

    /**
     * Make and return a cache id
     *
     * Checks 'cache_id_prefix' and returns new id with prefix or simply the id if null
     *
     * @param  string $id Cache id
     * @return string Cache id (with or without prefix)
     */
    protected function _id($id)
    {
        if ($id !== null) {
            $id = preg_replace('/([^a-zA-Z0-9_]{1,1})/', '_', $id);
            if (isset($this->_options['cache_id_prefix'])) {
                $id = $this->_options['cache_id_prefix'] . $id;
            }
        }
        return $id;
    }

    /**
     * Prepare tags
     *
     * @param array $tags
     * @return array
     */
    protected function _tags($tags)
    {
        foreach ($tags as $key=>$tag) {
            $tags[$key] = $this->_id($tag);
        }
        return $tags;
    }

    /**
     * Save some data in a cache
     *
     * @param  mixed $data           Data to put in cache (can be another type than string if automatic_serialization is on)
     * @param  string $id             Cache id (if not set, the last cache id will be used)
     * @param  array $tags           Cache tags
     * @param bool|int $specificLifetime If != false, set a specific lifetime for this cache record (null => infinite lifetime)
     * @param  int $priority         integer between 0 (very low priority) and 10 (maximum priority) used by some particular backends
     * @return boolean True if no problem
     */
    public function save($data, $id = null, $tags = array(), $specificLifetime = false, $priority = 8)
    {
        $tags = $this->_tags($tags);

        if ($this->getOption('slab_size') && is_string($data) && (strlen($data) > $this->getOption('slab_size'))) {
            $dataChunks = str_split($data, $this->getOption('slab_size'));

            for ($i = 0, $cnt = count($dataChunks); $i < $cnt; $i++) {
                $chunkId = $this->_getChunkId($id, $i);

                if (!$this->_save($dataChunks[$i], $chunkId, $tags, $specificLifetime, $priority)) {
                    $this->_cleanTheMess($id, $i + 1);
                    return false;
                }
            }

            $data = self::CODE_WORD . '|' . $i;
        }

        return $this->_save($data, $id, $tags, $specificLifetime, $priority);
    }
    
    /**
     * Save some data in a cache
     *
     * @param  mixed $data           Data to put in cache (can be another type than string if automatic_serialization is on)
     * @param  string $id             Cache id (if not set, the last cache id will be used)
     * @param  array $tags           Cache tags
     * @param  int $specificLifetime If != false, set a specific lifetime for this cache record (null => infinite lifetime)
     * @param  int   $priority         integer between 0 (very low priority) and 10 (maximum priority) used by some particular backends
     * @throws Varien_Cache_Exception
     * @return boolean True if no problem
     */
    protected function _save($data, $id = null, $tags = array(), $specificLifetime = false, $priority = 8)
    {
        if (!$this->_options['caching']) {
            return true;
        }
        if ($id === null) {
            $id = $this->_lastId;
        } else {
            $id = $this->_id($id);
        }
        $this->_validateIdOrTag($id);
        $this->_validateTagsArray($tags);
        if ($this->_options['automatic_serialization']) {
            // we need to serialize datas before storing them
            $data = serialize($data);
        } else {
            if (!is_string($data)) {
                Varien_Cache::throwException("Datas must be string or set automatic_serialization = true");
            }
        }

        // automatic cleaning
        if ($this->_options['automatic_cleaning_factor'] > 0) {
            $rand = rand(1, $this->_options['automatic_cleaning_factor']);
            if ($rand==1) {
                //  new way                 || deprecated way
                if ($this->_extendedBackend || method_exists($this->_backend, 'isAutomaticCleaningAvailable')) {
                    $this->_log("Varien_Cache_Core::save(): automatic cleaning running", 7);
                    $this->clean(Varien_Cache::CLEANING_MODE_OLD);
                } else {
                    $this->_log("Varien_Cache_Core::save(): automatic cleaning is not available/necessary with current backend", 4);
                }
            }
        }

        $this->_log("Varien_Cache_Core: save item '{$id}'", 7);
        if ($this->_options['ignore_user_abort']) {
            $abort = ignore_user_abort(true);
        }
        if (($this->_extendedBackend) && ($this->_backendCapabilities['priority'])) {
            $result = $this->_backend->save($data, $id, $tags, $specificLifetime, $priority);
        } else {
            $result = $this->_backend->save($data, $id, $tags, $specificLifetime);
        }
        if ($this->_options['ignore_user_abort']) {
            ignore_user_abort($abort);
        }

        if (!$result) {
            // maybe the cache is corrupted, so we remove it !
            $this->_log("Varien_Cache_Core::save(): failed to save item '{$id}' -> removing it", 4);
            $this->_backend->remove($id);
            return false;
        }

        if ($this->_options['write_control']) {
            $data2 = $this->_backend->load($id, true);
            if ($data!=$data2) {
                $this->_log("Varien_Cache_Core::save(): write control of item '{$id}' failed -> removing it", 4);
                $this->_backend->remove($id);
                return false;
            }
        }

        return true;
    }

    /**
     * Load data from cached, glue from several chunks if it was splitted upon save.
     *
     * @param  string  $id                     Cache id
     * @param  boolean $doNotTestCacheValidity If set to true, the cache validity won't be tested
     * @param  boolean $doNotUnserialize       Do not serialize (even if automatic_serialization is true) => for internal use
     * @return mixed|false Cached datas
     */
    public function load($id, $doNotTestCacheValidity = false, $doNotUnserialize = false)
    {
        $data = $this->_load($id, $doNotTestCacheValidity, $doNotUnserialize);

        if (is_string($data) && (substr($data, 0, strlen(self::CODE_WORD)) == self::CODE_WORD)) {
            // Seems we've got chunked data

            $arr = explode('|', $data);
            $chunks = isset($arr[1]) ? $arr[1] : false;
            $chunkData = array();

            if ($chunks && is_numeric($chunks)) {
                for ($i = 0; $i < $chunks; $i++) {
                    $chunk = $this->_load($this->_getChunkId($id, $i), $doNotTestCacheValidity, $doNotUnserialize);

                    if (false === $chunk) {
                        // Some chunk in chain was not found, we can not glue-up the data:
                        // clean the mess and return nothing

                        $this->_cleanTheMess($id, $chunks);
                        return false;
                    }

                    $chunkData[] = $chunk;
                }

                return implode('', $chunkData);
            }
        }

        // Data has not been splitted to chunks on save
        return $data;
    }
    
    
    /**
     * Test if a cache is available for the given id and (if yes) return it (false else)
     *
     * @param  string  $id                     Cache id
     * @param  boolean $doNotTestCacheValidity If set to true, the cache validity won't be tested
     * @param  boolean $doNotUnserialize       Do not serialize (even if automatic_serialization is true) => for internal use
     * @return mixed|false Cached datas
     */
    protected function _load($id, $doNotTestCacheValidity = false, $doNotUnserialize = false)
    {
        if (!$this->_options['caching']) {
            return false;
        }
        $id = $this->_id($id); // cache id may need prefix
        $this->_lastId = $id;
        $this->_validateIdOrTag($id);

        $this->_log("Varien_Cache_Core: load item '{$id}'", 7);
        $data = $this->_backend->load($id, $doNotTestCacheValidity);
        if ($data===false) {
            // no cache available
            return false;
        }
        if ((!$doNotUnserialize) && $this->_options['automatic_serialization']) {
            // we need to unserialize before sending the result
            return unserialize($data);
        }
        return $data;
    }
    

    /**
     * Clean cache entries
     *
     * Available modes are :
     * 'all' (default)  => remove all cache entries ($tags is not used)
     * 'old'            => remove too old cache entries ($tags is not used)
     * 'matchingTag'    => remove cache entries matching all given tags
     *                     ($tags can be an array of strings or a single string)
     * 'notMatchingTag' => remove cache entries not matching one of the given tags
     *                     ($tags can be an array of strings or a single string)
     * 'matchingAnyTag' => remove cache entries matching any given tags
     *                     ($tags can be an array of strings or a single string)
     *
     * @param  string       $mode
     * @param  array|string $tags
     * @throws Varien_Cache_Exception
     * @return boolean True if ok
     */
    public function clean($mode = 'all', $tags = array())
    {
        $tags = $this->_tags($tags);
        if (!$this->_options['caching']) {
            return true;
        }
        if (!in_array($mode, array(Varien_Cache::CLEANING_MODE_ALL,
                                   Varien_Cache::CLEANING_MODE_OLD,
                                   Varien_Cache::CLEANING_MODE_MATCHING_TAG,
                                   Varien_Cache::CLEANING_MODE_NOT_MATCHING_TAG,
                                   Varien_Cache::CLEANING_MODE_MATCHING_ANY_TAG))) {
            Varien_Cache::throwException('Invalid cleaning mode');
        }
        $this->_validateTagsArray($tags);

        return $this->_backend->clean($mode, $tags);
    }

    /**
     * Return an array of stored cache ids which match given tags
     *
     * In case of multiple tags, a logical AND is made between tags
     *
     * @param array $tags array of tags
     * @return array array of matching cache ids (string)
     */
    public function getIdsMatchingTags($tags = array())
    {
        $tags = $this->_tags($tags);
        if (!$this->_extendedBackend) {
            Varien_Cache::throwException(self::BACKEND_NOT_IMPLEMENTS_EXTENDED_IF);
        }
        if (!($this->_backendCapabilities['tags'])) {
            Varien_Cache::throwException(self::BACKEND_NOT_SUPPORTS_TAG);
        }

        $ids = $this->_backend->getIdsMatchingTags($tags);

        // we need to remove cache_id_prefix from ids (see #ZF-6178, #ZF-7600)
        if (isset($this->_options['cache_id_prefix']) && $this->_options['cache_id_prefix'] !== '') {
            $prefix    = & $this->_options['cache_id_prefix'];
            $prefixLen = strlen($prefix);
            foreach ($ids as &$id) {
                if (strpos($id, $prefix) === 0) {
                    $id = substr($id, $prefixLen);
                }
            }
        }

        return $ids;
    }

    /**
     * Return an array of stored cache ids which don't match given tags
     *
     * In case of multiple tags, a logical OR is made between tags
     *
     * @param array $tags array of tags
     * @return array array of not matching cache ids (string)
     */
    public function getIdsNotMatchingTags($tags = array())
    {
        $tags = $this->_tags($tags);
        if (!$this->_extendedBackend) {
            Varien_Cache::throwException(self::BACKEND_NOT_IMPLEMENTS_EXTENDED_IF);
        }
        if (!($this->_backendCapabilities['tags'])) {
            Varien_Cache::throwException(self::BACKEND_NOT_SUPPORTS_TAG);
        }

        $ids = $this->_backend->getIdsNotMatchingTags($tags);

        // we need to remove cache_id_prefix from ids (see #ZF-6178, #ZF-7600)
        if (isset($this->_options['cache_id_prefix']) && $this->_options['cache_id_prefix'] !== '') {
            $prefix    = & $this->_options['cache_id_prefix'];
            $prefixLen = strlen($prefix);
            foreach ($ids as &$id) {
                if (strpos($id, $prefix) === 0) {
                    $id = substr($id, $prefixLen);
                }
            }
        }

        return $ids;
    }
    
    
    /**
     * Public frontend to get an option value
     *
     * @param  string $name  Name of the option
     * @throws Zend_Cache_Exception
     * @return mixed option value
     */
    public function getOption($name)
    {
        $name = strtolower($name);

        if (array_key_exists($name, $this->_options)) {
            // This is a Core option
            return $this->_options[$name];
        }

        if (array_key_exists($name, $this->_specificOptions)) {
            // This a specic option of this frontend
            return $this->_specificOptions[$name];
        }

        Varien_Cache::throwException("Incorrect option name : $name");
    }
}

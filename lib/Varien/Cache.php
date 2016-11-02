<?php
abstract class Varien_Cache
{

    /**
     * Standard frontends
     *
     * @var array
     */
    public static $standardFrontends = array('Core', 'Output', 'Class', 'File', 'Function', 'Page');

    /**
     * Standard backends
     *
     * @var array
     */
    public static $standardBackends = array('File', 'Memcached', 'Libmemcached', 'Apc', 'ZendPlatform',
                                            'Xcache', 'TwoLevels', 'WinCache', 'ZendServer_Disk', 'ZendServer_ShMem');
	//与eAccelerator正好相反的是WinCache要求使用NTS(非线程安全)版本的PHP，因此更适合与FastCGI配合使用
    /**
     * Standard backends which implement the ExtendedInterface
     *
     * @var array
     */
    public static $standardExtendedBackends = array('File', 'Apc', 'TwoLevels', 'Memcached', 'Libmemcached','WinCache');

    /**
     * Only for backward compatibility (may be removed in next major release)
     *
     * @var array
     * @deprecated
     */
    public static $availableFrontends = array('Core', 'Output', 'Class', 'File', 'Function', 'Page');

    /**
     * Only for backward compatibility (may be removed in next major release)
     *
     * @var array
     * @deprecated
     */
    public static $availableBackends = array('File', 'Memcached', 'Libmemcached', 'Apc', 'ZendPlatform', 'Xcache', 'WinCache', 'TwoLevels');

    /**
     * Consts for clean() method
     */
    const CLEANING_MODE_ALL              = 'all';
    const CLEANING_MODE_OLD              = 'old';
    const CLEANING_MODE_MATCHING_TAG     = 'matchingTag';
    const CLEANING_MODE_NOT_MATCHING_TAG = 'notMatchingTag';
    const CLEANING_MODE_MATCHING_ANY_TAG = 'matchingAnyTag';

    /**
     * Factory
     *
     * @param mixed  $frontend        Varien_Cache_Core
     * @param mixed  $backend         backend name (string) or Varien_Cache_Backend_ object
     * @param array  $frontendOptions associative array of options for the corresponding frontend constructor
     * @param array  $backendOptions  associative array of options for the corresponding backend constructor
     * @param boolean $customFrontendNaming if true, the frontend argument is used as a complete class name ; if false, the frontend argument is used as the end of "Varien_Cache_Frontend_[...]" class name
     * @param boolean $customBackendNaming if true, the backend argument is used as a complete class name ; if false, the backend argument is used as the end of "Varien_Cache_Backend_[...]" class name
     * @param boolean $autoload if true, there will no #require_once for backend and frontend (useful only for custom backends/frontends)
     * @throws Varien_Cache_Exception
     * @return Varien_Cache_Core|Varien_Cache_Frontend
     */
    public static function factory($frontend, $backend, $frontendOptions = array(), $backendOptions = array(), $customFrontendNaming = false, $customBackendNaming = false, $autoload = false)
    {
        if (is_string($backend)) {
            $backendObject = self::_makeBackend($backend, $backendOptions, $customBackendNaming, $autoload);
        } else {
        	//class_implements 返回指定的类实现的所有接口
            if ((is_object($backend)) && (in_array('Varien_Cache_Backend_Interface', class_implements($backend)))) {
                $backendObject = $backend;
            } else {
                self::throwException('backend must be a backend name (string) or an object which implements Varien_Cache_Backend_Interface');
            }
        }
        if (is_string($frontend)) {
            $frontendObject = self::_makeFrontend($frontend, $frontendOptions, $customFrontendNaming, $autoload);
        } else {
            if (is_object($frontend)) {
                $frontendObject = $frontend;
            } else {
                self::throwException('frontend must be a frontend name (string) or an object');
            }
        }
        
        $frontendObject->setBackend($backendObject);
        return $frontendObject;
    }

    /**
     * Backend Constructor
     *
     * @param string  $backend
     * @param array   $backendOptions
     * @param boolean $customBackendNaming
     * @param boolean $autoload
     * @return Varien_Cache_Backend
     */
    public static function _makeBackend($backend, $backendOptions, $customBackendNaming = false, $autoload = false)
    {
        if (!$customBackendNaming) {
            $backend  = self::_normalizeName($backend);
        }
        
        if (in_array($backend, self::$standardBackends)) {
            $backendClass = 'Varien_Cache_Backend_' . $backend;
        } else {
            // we use a custom backend
            if (!preg_match('~^[\w\\\\]+$~D', $backend)) {
                Varien_Cache::throwException("Invalid backend name [$backend]");
            }
            if (!$customBackendNaming) {
                // we use this boolean to avoid an API break
                $backendClass = 'Varien_Cache_Backend_' . $backend;
            } else {
            	
                $backendClass = $backend;
            }
            if (!$autoload) {
                $file = str_replace('_', DIRECTORY_SEPARATOR, $backendClass) . '.php';
                if (!(self::_isReadable($file))) {
                    self::throwException("file $file not found in include_path");
                }
                #require_once $file;
            }
        }
        //var_dump($backendClass);die();
        return new $backendClass($backendOptions);
    }

    /**
     * Frontend Constructor
     *
     * @param string  $frontend
     * @param array   $frontendOptions
     * @param boolean $customFrontendNaming
     * @param boolean $autoload
     * @return Varien_Cache_Core|Varien_Cache_Frontend
     */
    public static function _makeFrontend($frontend, $frontendOptions = array(), $customFrontendNaming = false, $autoload = false)
    {
        if (!$customFrontendNaming) {
            $frontend = self::_normalizeName($frontend);
        }
        
        if (in_array($frontend, self::$standardFrontends)) {
            // we use a standard frontend
            // For perfs reasons, with frontend == 'Core', we can interact with the Core itself
            $frontendClass = 'Varien_Cache_' . ($frontend != 'Core' ? 'Frontend_' : '') . $frontend;
            // security controls are explicit
            #require_once str_replace('_', DIRECTORY_SEPARATOR, $frontendClass) . '.php';
        } else {
            // we use a custom frontend
            if (!preg_match('~^[\w\\\\]+$~D', $frontend)) {
                Varien_Cache::throwException("Invalid frontend name [$frontend]");
            }
            if (!$customFrontendNaming) {
                // we use this boolean to avoid an API break
                $frontendClass = 'Varien_Cache_Frontend_' . $frontend;
            } else {
            	
                $frontendClass = $frontend;
            }
            if (!$autoload) {
                $file = str_replace('_', DIRECTORY_SEPARATOR, $frontendClass) . '.php';
               
                if (!(self::_isReadable($file))) {
                    self::throwException("file $file not found in include_path");
                }
            }
        }
        return new $frontendClass($frontendOptions);
    }

    /**
     * Throw an exception
     *
     * Note : for perf reasons, the "load" of Zend/Cache/Exception is dynamic
     * @param  string $msg  Message for the exception
     * @throws Varien_Cache_Exception
     */
    public static function throwException($msg, Exception $e = null)
    {
        // For perfs reasons, we use this dynamic inclusion
        #require_once 'Zend/Cache/Exception.php';
        throw new Varien_Cache_Exception($msg, 0, $e);
    }

    /**
     * Normalize frontend and backend names to allow multiple words TitleCased
     *
     * @param  string $name  Name to normalize
     * @return string
     */
    protected static function _normalizeName($name)
    {
        $name = ucfirst(strtolower($name));
        $name = str_replace(array('-', '_', '.'), ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        if (stripos($name, 'ZendServer') === 0) {
            $name = 'ZendServer_' . substr($name, strlen('ZendServer'));
        }

        return $name;
    }

    /**
     * Returns TRUE if the $filename is readable, or FALSE otherwise.
     * This function uses the PHP include_path, where PHP's is_readable()
     * does not.
     *
     * Note : this method comes from Varien_Loader (see #ZF-2891 for details)
     *
     * @param string   $filename
     * @return boolean
     */
    private static function _isReadable($filename)
    {
        if (!$fh = @fopen($filename, 'r', true)) {
            return false;
        }
        @fclose($fh);
        return true;
    }

}

<?php
/**
 * Varien Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Varien
 * @package    Varien_Log
 * @subpackage Writer
 * @copyright  Copyright (c) 2005-2015 Varien Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/** Varien_Log_Writer_Abstract */
#require_once 'Varien/Log/Writer/Abstract.php';

/** Varien_Log_Formatter_Simple */
#require_once 'Varien/Log/Formatter/Simple.php';

/**
 * @category   Varien
 * @package    Varien_Log
 * @subpackage Writer
 * @copyright  Copyright (c) 2005-2015 Varien Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Varien_Log_Writer_Stream extends Varien_Log_Writer_Abstract
{
    /**
     * Holds the PHP stream to log to.
     *
     * @var null|stream
     */
    protected $_stream = null;

    /**
     * Class Constructor
     *
     * @param array|string|resource $streamOrUrl Stream or URL to open as a stream
     * @param string|null $mode Mode, only applicable if a URL is given
     * @return void
     * @throws Varien_Log_Exception
     */
    public function __construct($streamOrUrl, $mode = null)
    {
        // Setting the default
        if (null === $mode) {
            $mode = 'a';
        }

        if (is_resource($streamOrUrl)) {
            if (get_resource_type($streamOrUrl) != 'stream') {
                #require_once 'Varien/Log/Exception.php';
                throw new Varien_Log_Exception('Resource is not a stream');
            }

            if ($mode != 'a') {
                #require_once 'Varien/Log/Exception.php';
                throw new Varien_Log_Exception('Mode cannot be changed on existing streams');
            }

            $this->_stream = $streamOrUrl;
        } else {
            if (is_array($streamOrUrl) && isset($streamOrUrl['stream'])) {
                $streamOrUrl = $streamOrUrl['stream'];
            }

            if (! $this->_stream = @fopen($streamOrUrl, $mode, false)) {
                #require_once 'Varien/Log/Exception.php';
                $msg = "\"$streamOrUrl\" cannot be opened with mode \"$mode\"";
                throw new Varien_Log_Exception($msg);
            }
        }

        $this->_formatter = new Varien_Log_Formatter_Simple();
    }

    /**
     * Create a new instance of Varien_Log_Writer_Stream
     *
     * @param  array|Varien_Config $config
     * @return Varien_Log_Writer_Stream
     */
    static public function factory($config)
    {
        $config = self::_parseConfig($config);
        $config = array_merge(array(
            'stream' => null,
            'mode'   => null,
        ), $config);

        $streamOrUrl = isset($config['url']) ? $config['url'] : $config['stream'];

        return new self(
            $streamOrUrl,
            $config['mode']
        );
    }

    /**
     * Close the stream resource.
     *
     * @return void
     */
    public function shutdown()
    {
        if (is_resource($this->_stream)) {
            fclose($this->_stream);
        }
    }

    /**
     * Write a message to the log.
     *
     * @param  array  $event  event data
     * @return void
     * @throws Varien_Log_Exception
     */
    protected function _write($event)
    {
        $line = $this->_formatter->format($event);

        if (false === @fwrite($this->_stream, $line)) {
            #require_once 'Varien/Log/Exception.php';
            throw new Varien_Log_Exception("Unable to write to stream");
        }
    }
}

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
 * @subpackage Formatter
 * @copyright  Copyright (c) 2005-2015 Varien Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/** Varien_Log_Formatter_Abstract */
#require_once 'Varien/Log/Formatter/Abstract.php';

/**
 * @category   Varien
 * @package    Varien_Log
 * @subpackage Formatter
 * @copyright  Copyright (c) 2005-2015 Varien Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Varien_Log_Formatter_Simple extends Varien_Log_Formatter_Abstract
{
    /**
     * @var string
     */
    protected $_format;

    const DEFAULT_FORMAT = '%timestamp% %priorityName% (%priority%): %message%';

    /**
     * Class constructor
     *
     * @param  null|string  $format  Format specifier for log messages
     * @return void
     * @throws Varien_Log_Exception
     */
    public function __construct($format = null)
    {
        if ($format === null) {
            $format = self::DEFAULT_FORMAT . PHP_EOL;
        }

        if (!is_string($format)) {
            #require_once 'Varien/Log/Exception.php';
            throw new Varien_Log_Exception('Format must be a string');
        }

        $this->_format = $format;
    }

    /**
	 * Factory for Varien_Log_Formatter_Simple classe
	 *
	 * @param array|Varien_Config $options
	 * @return Varien_Log_Formatter_Simple
     */
    public static function factory($options)
    {
        $format = null;
        if (null !== $options) {
            if ($options instanceof Varien_Config) {
                $options = $options->toArray();
            }

            if (array_key_exists('format', $options)) {
                $format = $options['format'];
            }
        }

        return new self($format);
    }

    /**
     * Formats data into a single line to be written by the writer.
     *
     * @param  array    $event    event data
     * @return string             formatted line to write to the log
     */
    public function format($event)
    {
        $output = $this->_format;

        foreach ($event as $name => $value) {
            if ((is_object($value) && !method_exists($value,'__toString'))
                || is_array($value)
            ) {
                $value = gettype($value);
            }

            $output = str_replace("%$name%", $value, $output);
        }

        return $output;
    }
}

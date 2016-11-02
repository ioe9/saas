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

/** Varien_Log */
#require_once 'Varien/Log.php';

/** Varien_Log_Writer_Abstract */
#require_once 'Varien/Log/Writer/Abstract.php';

/** Varien_Log_Formatter_Firebug */
#require_once 'Varien/Log/Formatter/Firebug.php';

/** Varien_Wildfire_Plugin_FirePhp */
#require_once 'Varien/Wildfire/Plugin/FirePhp.php';

/**
 * Writes log messages to the Firebug Console via FirePHP.
 *
 * @category   Varien
 * @package    Varien_Log
 * @subpackage Writer
 * @copyright  Copyright (c) 2005-2015 Varien Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Varien_Log_Writer_Firebug extends Varien_Log_Writer_Abstract
{
    /**
     * Maps logging priorities to logging display styles
     *
     * @var array
     */
    protected $_priorityStyles = array(Varien_Log::EMERG  => Varien_Wildfire_Plugin_FirePhp::ERROR,
                                       Varien_Log::ALERT  => Varien_Wildfire_Plugin_FirePhp::ERROR,
                                       Varien_Log::CRIT   => Varien_Wildfire_Plugin_FirePhp::ERROR,
                                       Varien_Log::ERR    => Varien_Wildfire_Plugin_FirePhp::ERROR,
                                       Varien_Log::WARN   => Varien_Wildfire_Plugin_FirePhp::WARN,
                                       Varien_Log::NOTICE => Varien_Wildfire_Plugin_FirePhp::INFO,
                                       Varien_Log::INFO   => Varien_Wildfire_Plugin_FirePhp::INFO,
                                       Varien_Log::DEBUG  => Varien_Wildfire_Plugin_FirePhp::LOG);

    /**
     * The default logging style for un-mapped priorities
     *
     * @var string
     */
    protected $_defaultPriorityStyle = Varien_Wildfire_Plugin_FirePhp::LOG;

    /**
     * Flag indicating whether the log writer is enabled
     *
     * @var boolean
     */
    protected $_enabled = true;

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        if (php_sapi_name() == 'cli') {
            $this->setEnabled(false);
        }

        $this->_formatter = new Varien_Log_Formatter_Firebug();
    }

    /**
     * Create a new instance of Varien_Log_Writer_Firebug
     *
     * @param  array|Varien_Config $config
     * @return Varien_Log_Writer_Firebug
     */
    static public function factory($config)
    {
        return new self();
    }

    /**
     * Enable or disable the log writer.
     *
     * @param boolean $enabled Set to TRUE to enable the log writer
     * @return boolean The previous value.
     */
    public function setEnabled($enabled)
    {
        $previous = $this->_enabled;
        $this->_enabled = $enabled;
        return $previous;
    }

    /**
     * Determine if the log writer is enabled.
     *
     * @return boolean Returns TRUE if the log writer is enabled.
     */
    public function getEnabled()
    {
        return $this->_enabled;
    }

    /**
     * Set the default display style for user-defined priorities
     *
     * @param string $style The default log display style
     * @return string Returns previous default log display style
     */
    public function setDefaultPriorityStyle($style)
    {
        $previous = $this->_defaultPriorityStyle;
        $this->_defaultPriorityStyle = $style;
        return $previous;
    }

    /**
     * Get the default display style for user-defined priorities
     *
     * @return string Returns the default log display style
     */
    public function getDefaultPriorityStyle()
    {
        return $this->_defaultPriorityStyle;
    }

    /**
     * Set a display style for a logging priority
     *
     * @param int $priority The logging priority
     * @param string $style The logging display style
     * @return string|boolean The previous logging display style if defined or TRUE otherwise
     */
    public function setPriorityStyle($priority, $style)
    {
        $previous = true;
        if (array_key_exists($priority,$this->_priorityStyles)) {
            $previous = $this->_priorityStyles[$priority];
        }
        $this->_priorityStyles[$priority] = $style;
        return $previous;
    }

    /**
     * Get a display style for a logging priority
     *
     * @param int $priority The logging priority
     * @return string|boolean The logging display style if defined or FALSE otherwise
     */
    public function getPriorityStyle($priority)
    {
        if (array_key_exists($priority,$this->_priorityStyles)) {
            return $this->_priorityStyles[$priority];
        }
        return false;
    }

    /**
     * Log a message to the Firebug Console.
     *
     * @param array $event The event data
     * @return void
     */
    protected function _write($event)
    {
        if (!$this->getEnabled()) {
            return;
        }

        if (array_key_exists($event['priority'],$this->_priorityStyles)) {
            $type = $this->_priorityStyles[$event['priority']];
        } else {
            $type = $this->_defaultPriorityStyle;
        }

        $message = $this->_formatter->format($event);

        $label = isset($event['firebugLabel'])?$event['firebugLabel']:null;

        Varien_Wildfire_Plugin_FirePhp::getInstance()->send($message,
                                                          $label,
                                                          $type,
                                                          array('traceOffset'=>4,
                                                                'fixVarienLogOffsetIfApplicable'=>true));
    }
}

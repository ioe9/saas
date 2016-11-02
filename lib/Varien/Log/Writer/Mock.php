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

/**
 * @category   Varien
 * @package    Varien_Log
 * @subpackage Writer
 * @copyright  Copyright (c) 2005-2015 Varien Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Varien_Log_Writer_Mock extends Varien_Log_Writer_Abstract
{
    /**
     * array of log events
     *
     * @var array
     */
    public $events = array();

    /**
     * shutdown called?
     *
     * @var boolean
     */
    public $shutdown = false;

    /**
     * Write a message to the log.
     *
     * @param  array  $event  event data
     * @return void
     */
    public function _write($event)
    {
        $this->events[] = $event;
    }

    /**
     * Record shutdown
     *
     * @return void
     */
    public function shutdown()
    {
        $this->shutdown = true;
    }

    /**
     * Create a new instance of Varien_Log_Writer_Mock
     *
     * @param  array|Varien_Config $config
     * @return Varien_Log_Writer_Mock
     */
    static public function factory($config)
    {
        return new self();
    }
}

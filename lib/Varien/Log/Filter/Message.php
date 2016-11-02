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
 * @subpackage Filter
 * @copyright  Copyright (c) 2005-2015 Varien Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/** Varien_Log_Filter_Abstract */
#require_once 'Varien/Log/Filter/Abstract.php';

/**
 * @category   Varien
 * @package    Varien_Log
 * @subpackage Filter
 * @copyright  Copyright (c) 2005-2015 Varien Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Varien_Log_Filter_Message extends Varien_Log_Filter_Abstract
{
    /**
     * @var string
     */
    protected $_regexp;

    /**
     * Filter out any log messages not matching $regexp.
     *
     * @param  string  $regexp     Regular expression to test the log message
     * @return void
     * @throws Varien_Log_Exception
     */
    public function __construct($regexp)
    {
        if (@preg_match($regexp, '') === false) {
            #require_once 'Varien/Log/Exception.php';
            throw new Varien_Log_Exception("Invalid regular expression '$regexp'");
        }
        $this->_regexp = $regexp;
    }

    /**
     * Create a new instance of Varien_Log_Filter_Message
     *
     * @param  array|Varien_Config $config
     * @return Varien_Log_Filter_Message
     */
    static public function factory($config)
    {
        $config = self::_parseConfig($config);
        $config = array_merge(array(
            'regexp' => null
        ), $config);

        return new self(
            $config['regexp']
        );
    }

    /**
     * Returns TRUE to accept the message, FALSE to block it.
     *
     * @param  array    $event    event data
     * @return boolean            accepted?
     */
    public function accept($event)
    {
        return preg_match($this->_regexp, $event['message']) > 0;
    }
}

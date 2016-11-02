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
class Varien_Log_Writer_Null extends Varien_Log_Writer_Abstract
{
    /**
     * Write a message to the log.
     *
     * @param  array  $event  event data
     * @return void
     */
    protected function _write($event)
    {
    }

    /**
     * Create a new instance of Varien_Log_Writer_Null
     *
     * @param  array|Varien_Config $config
     * @return Varien_Log_Writer_Null
     */
    static public function factory($config)
    {
        return new self();
    }
}

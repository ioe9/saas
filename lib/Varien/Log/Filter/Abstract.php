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

/** @see Varien_Log_Filter_Interface */
#require_once 'Varien/Log/Filter/Interface.php';

/** @see Varien_Log_FactoryInterface */
#require_once 'Varien/Log/FactoryInterface.php';

/**
 * @category   Varien
 * @package    Varien_Log
 * @subpackage Filter
 * @copyright  Copyright (c) 2005-2015 Varien Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
abstract class Varien_Log_Filter_Abstract
    implements Varien_Log_Filter_Interface, Varien_Log_FactoryInterface
{
    /**
     * Validate and optionally convert the config to array
     *
     * @param  array|Varien_Config $config Varien_Config or Array
     * @return array
     * @throws Varien_Log_Exception
     */
    static protected function _parseConfig($config)
    {
        if ($config instanceof Varien_Config) {
            $config = $config->toArray();
        }

        if (!is_array($config)) {
            #require_once 'Varien/Log/Exception.php';
            throw new Varien_Log_Exception('Configuration must be an array or instance of Varien_Config');
        }

        return $config;
    }
}

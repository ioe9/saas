<?php
/**
 * Zend Framework
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
 * @category   Zend
 * @package    Varien_Mail
 * @subpackage Storage
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */


/**
 * @category   Zend
 * @package    Varien_Mail
 * @subpackage Storage
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
interface Varien_Mail_Storage_Folder_Interface
{
    /**
     * get root folder or given folder
     *
     * @param string $rootFolder get folder structure for given folder, else root
     * @return Varien_Mail_Storage_Folder root or wanted folder
     */
    public function getFolders($rootFolder = null);

    /**
     * select given folder
     *
     * folder must be selectable!
     *
     * @param Varien_Mail_Storage_Folder|string $globalName global name of folder or instance for subfolder
     * @return null
     * @throws Varien_Mail_Storage_Exception
     */
    public function selectFolder($globalName);


    /**
     * get Varien_Mail_Storage_Folder instance for current folder
     *
     * @return Varien_Mail_Storage_Folder instance of current folder
     * @throws Varien_Mail_Storage_Exception
     */
    public function getCurrentFolder();
}

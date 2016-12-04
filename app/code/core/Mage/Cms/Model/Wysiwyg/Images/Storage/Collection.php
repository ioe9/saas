<?php
/**
 *
 * @category    Mage
 * @package     Mage_Cms
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Wysiwyg Images storage collection
 *
 * @category    Mage
 * @package     Mage_Cms
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Cms_Model_Wysiwyg_Images_Storage_Collection extends Varien_Data_Collection_Filesystem
{
    protected function _generateRow($filename)
    {
        $filename = preg_replace('~[/\\\]+~', DIRECTORY_SEPARATOR, $filename);
        
        return array(
            'filename' => $filename,
            'basename' => basename($filename),
            'mtime'    => filemtime($filename)
        );
    }
}

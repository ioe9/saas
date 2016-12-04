<?php
/**
 * Url rewrite interface
 *
 * @category Mage
 * @package Mage_Core
 * @author Mio Core Team <developer@ioe9.com>
 */
interface Mage_Core_Model_Url_Rewrite_Interface
{
    /**
     * Load rewrite information for request
     *
     * @param array|string $path
     * @return Mage_Core_Model_Url_Rewrite_Interface
     */
    public function loadByRequestPath($path);
}

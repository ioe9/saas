<?php
/**
 * Core unserialize helper
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Helper_UnserializeArray
{
    /**
     * @param string $str
     * @return array
     * @throws Exception
     */
    public function unserialize($str)
    {
        $parser = new Unserialize_Parser();
        return $parser->unserialize($str);
    }
}

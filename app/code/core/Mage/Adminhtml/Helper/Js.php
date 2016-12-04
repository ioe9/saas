<?php
/**
 * Adminhtml JavaScript helper
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Helper_Js extends Mage_Core_Helper_Js
{
    /**
     * Decode serialized grid data
     *
     * Ignores non-numeric array keys
     *
     * '1&2&3&4' will be decoded into:
     * array(1, 2, 3, 4);
     *
     * otherwise the following format is anticipated:
     * 1=<encoded string>&2=<encoded string>:
     * array (
     *   1 => array(...),
     *   2 => array(...),
     * )
     *
     * @param   string $encoded
     * @return  array
     */
    public function decodeGridSerializedInput($encoded)
    {
        $isSimplified = (false === strpos($encoded, '='));
        $result = array();
        parse_str($encoded, $decoded);
        foreach($decoded as $key => $value) {
            if (is_numeric($key)) {
                if ($isSimplified) {
                    $result[] = $key;
                } else {
                    $result[$key] = null;
                    parse_str(base64_decode($value), $result[$key]);
                }
            }
        }
        return $result;
    }
}

<?php
/**
 * HTML anchor element block
 *
 * @category   Mage
 * @package    Mage_Core
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Block_Html_Link extends Mage_Core_Block_Template
{

    /**
     * Internal constructor
     *
     */
    protected function _construct()
    {
        $this->setTemplate('core/link.phtml');
        parent::_construct();
    }
    /**
     * Prepare link attributes as serialized and formated string
     *
     * @return string
     */
    public function getLinkAttributes()
    {
        $allow = array(
            'href', 'title', 'charset', 'name', 'hreflang', 'rel', 'rev', 'accesskey', 'shape',
            'coords', 'tabindex', 'onfocus', 'onblur', // %attrs
            'id', 'class', 'style', // %coreattrs
            'lang', 'dir', // %i18n
            'onclick', 'ondblclick', 'onmousedown', 'onmouseup', 'onmouseover', 'onmousemove',
            'onmouseout', 'onkeypress', 'onkeydown', 'onkeyup' // %events
        );

        $attributes = array();
        foreach ($allow as $attribute) {
            $value = $this->getDataUsingMethod($attribute);
            if (!is_null($value)) {
                $attributes[$attribute] = $this->escapeHtml($value);
            }
        }

        if (!empty($attributes)) {
            return $this->serialize($attributes);
        }
        return '';
    }

    /**
     * serialize attributes
     *
     * @param   array $attributes
     * @param   string $valueSeparator
     * @param   string $fieldSeparator
     * @param   string $quote
     * @return  string
     */
    public function serialize($attributes = array(), $valueSeparator='=', $fieldSeparator=' ', $quote='"')
    {
        $res  = '';
        $data = array();

        foreach ($attributes as $key => $value) {
            $data[] = $key . $valueSeparator . $quote . $value . $quote;
        }
        $res = implode($fieldSeparator, $data);
        return $res;
    }
}

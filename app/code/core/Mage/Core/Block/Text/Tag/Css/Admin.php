<?php
/**
 * Base html block
 *
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Block_Text_Tag_Css_Admin extends Mage_Core_Block_Text_Tag_Css
{

    protected function _construct()
    {
        parent::_construct();
        $theme = empty($_COOKIE['admtheme']) ? 'default' : $_COOKIE['admtheme'];
        $this->setAttribute('theme', $theme);
    }

    function setHref($href, $type=null)
    {
        $type = (string)$type;
        if (empty($type)) {
            $type = 'skin';
        }
        $url = Mage::getBaseUrl($type).$href.$this->getTheme().'.css';
        return $this->setTagParam('href', $url);
    }

}

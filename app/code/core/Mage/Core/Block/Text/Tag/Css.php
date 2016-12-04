<?php
/**
 * Base html block
 *
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Block_Text_Tag_Css extends Mage_Core_Block_Text_Tag
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTagName('link');
        $this->setTagParams(array('rel'=>'stylesheet', 'type'=>'text/css', 'media'=>'all'));
    }

    function setHref($href, $type=null)
    {
        $type = (string)$type;
        if (empty($type)) {
            $type = 'skin';
        }
        $url = Mage::getBaseUrl($type).$href;

        return $this->setTagParam('href', $url);
    }

}

<?php
/**
 * Base html block
 *
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Block_Text_Tag_Js extends Mage_Core_Block_Text_Tag
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTagName('script');
        $this->setTagParams(array('language'=>'javascript', 'type'=>'text/javascript'));
    }

    function setSrc($src, $type=null)
    {
        $type = (string)$type;
        if (empty($type)) {
            $type = 'js';
        }
        $url = Mage::getBaseUrl($type).$src;

        return $this->setTagParam('src', $url);
    }

}

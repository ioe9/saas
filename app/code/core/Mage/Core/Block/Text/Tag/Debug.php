<?php
/**
 * Base html block
 *
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Block_Text_Tag_Debug extends Mage_Core_Block_Text_Tag
{

    protected function _construct()
    {
        parent::_construct();
        $this->setAttribute(array(
          'tagName'=>'xmp',
        ));
    }

    function setValue($value)
    {
        return $this->setContents(print_r($value, 1));
    }

}

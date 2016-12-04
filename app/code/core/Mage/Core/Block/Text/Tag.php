<?php
/**
 * Base html block
 *
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Block_Text_Tag extends Mage_Core_Block_Text
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTagParams(array());
    }

    function setTagParam($param, $value=null)
    {
        if (is_array($param) && is_null($value)) {
            foreach ($param as $k=>$v) {
                $this->setTagParam($k, $v);
            }
        } else {
            $params = $this->getTagParams();
            $params[$param] = $value;
            $this->setTagParams($params);
        }
        return $this;
    }

    function setContents($text)
    {
        $this->setTagContents($text);
        return $this;
    }

    protected function _toHtml()
    {
        $this->setText('<'.$this->getTagName().' ');
        if ($this->getTagParams()) {
            foreach ($this->getTagParams() as $k=>$v) {
                $this->addText($k.'="'.$v.'" ');
            }
        }

        $this->addText('>'.$this->getTagContents().'</'.$this->getTagName().'>'."\r\n");
        return parent::_toHtml();
    }

}

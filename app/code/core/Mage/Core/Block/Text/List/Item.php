<?php
/**
 * List item block
 *
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Block_Text_List_Item extends Mage_Core_Block_Text
{
    function setLink($liParams, $innerText)
    {
        $this->setLiParams($liParams);
        $this->setInnerText($innerText);

        return $this;
    }

    protected function _toHtml()
    {
        $this->setText('<li');
        $params = $this->getLiParams();
        if (!empty($params) && is_array($params)) {
            foreach ($params as $key=>$value) {
                $this->addText(' '.$key.'="'.addslashes($value).'"');
            }
        } elseif (is_string($params)) {
            $this->addText(' '.$params);
        }
        $this->addText('>'.$this->getInnerText().'</li>'."\r\n");

        return parent::_toHtml();
    }

}

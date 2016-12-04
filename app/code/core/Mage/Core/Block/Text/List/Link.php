<?php
/**
 * Base html block
 *
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Core_Block_Text_List_Link extends Mage_Core_Block_Text
{
    function setLink($liParams, $aParams, $innerText, $afterText='')
    {
        $this->setLiParams($liParams);
        $this->setAParams($aParams);
        $this->setInnerText($innerText);
        $this->setAfterText($afterText);

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
        $this->addText('><a');

        $params = $this->getAParams();
        if (!empty($params) && is_array($params)) {
            foreach ($params as $key=>$value) {
                $this->addText(' '.$key.'="'.addslashes($value).'"');
            }
        } elseif (is_string($params)) {
            $this->addText(' '.$params);
        }

        $this->addText('>'.$this->getInnerText().'</a>'.$this->getAfterText().'</li>'."\r\n");

        return parent::_toHtml();
    }

}

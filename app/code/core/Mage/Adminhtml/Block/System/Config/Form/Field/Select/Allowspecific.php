<?php
/**
 * System congifuration shipping methods allow all countries selec
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_System_Config_Form_Field_Select_Allowspecific extends Varien_Data_Form_Element_Select
{

    public function getAfterElementHtml()
    {
        $javaScript = "
            <script type=\"text/javascript\">
                Event.observe('{$this->getHtmlId()}', 'change', function(){
                    specific=$('{$this->getHtmlId()}').value;
                    $('{$this->_getSpecificCountryElementId()}').disabled = (!specific || specific!=1);
                });
            </script>";
        return $javaScript . parent::getAfterElementHtml();
    }

    public function getHtml()
    {
        if(!$this->getValue() || $this->getValue()!=1) {
            $this->getForm()->getElement($this->_getSpecificCountryElementId())->setDisabled('disabled');
        }
        return parent::getHtml();
    }

    protected function _getSpecificCountryElementId()
    {
        return substr($this->getId(), 0, strrpos($this->getId(), 'allowspecific')) . 'specificcountry';
    }

}

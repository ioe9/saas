<?php
/**
 * Custom import CSV file field for shipping table rates
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_System_Config_Form_Field_Import extends Varien_Data_Form_Element_Abstract
{

    /**
     * Enter description here...
     *
     * @param array $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
        $this->setType('file');
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public function getElementHtml()
    {
        $html = '';

        $html .= '<input id="time_condition" type="hidden" name="'.$this->getName().'" value="'.time().'" />';

        $html .= <<<EndHTML
        <script type="text/javascript">
        Event.observe($('carriers_tablerate_condition_name'), 'change', checkConditionName.bind(this));
        function checkConditionName(event)
        {
            var conditionNameElement = Event.element(event);
            if (conditionNameElement && conditionNameElement.id) {
                $('time_condition').value = '_' + conditionNameElement.value + '/' + Math.random();
            }
        }
        </script>
EndHTML;

        $html .= parent::getElementHtml();

        return $html;
    }

}

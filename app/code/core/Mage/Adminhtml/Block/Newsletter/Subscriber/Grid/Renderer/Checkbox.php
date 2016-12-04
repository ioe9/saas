<?php
/**
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2016 Jongjian Ltd.Co.
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml newsletter subscribers grid checkbox item renderer
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */

class Mage_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Checkbox extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        if($row->getSubscriberStatus()==Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED) {
            return '<input type="checkbox" name="subscriber[]" value="' . $row->getId() . '" class="subscriberCheckbox"/>';
        } else {
            return '';
        }

    }
}// Class Mage_Adminhtml_Block_Newsletter_Subscriber_Grid_Renderer_Checkbox END

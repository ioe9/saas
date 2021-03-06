<?php
/**
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2016 Jongjian Ltd.Co.
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml newsletter subscribers grid filter checkbox
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */

class Mage_Adminhtml_Block_Newsletter_Subscriber_Grid_Filter_Checkbox extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Abstract
{
     public function getCondition()
    {
        return array();
    }

    public function getHtml()
    {
        return '<input type="checkbox" onclick="subscriberController.checkCheckboxes(this)"/>';
    }
}// Class Mage_Adminhtml_Block_Newsletter_Subscriber_Grid_Filter_Checkbox END

<?php
/**
 * Adminhtml HTML select element block
 *
 * @category   Mage
 * @package    Mage_Core
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Html_Date extends Mage_Core_Block_Html_Date
{

    /**
     * Enter description here...
     *
     * @return string
     */
    protected function _getUrlModelClass()
    {
        return 'adminhtml/url';
    }

}

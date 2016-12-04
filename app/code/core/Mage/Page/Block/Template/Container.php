<?php
/**
 * Abstract container block with header
 *
 * @category   Mage
 * @package    Mage_Core
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Page_Block_Template_Container extends Mage_Core_Block_Template
{

    /**
     * Set default template
     *
     */
    protected function _construct()
    {
        $this->setTemplate('page/template/container.phtml');
    }

}

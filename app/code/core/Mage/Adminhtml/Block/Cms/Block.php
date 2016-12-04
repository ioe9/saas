<?php
/**
 * Adminhtml cms blocks content block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Cms_Block extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'cms_block';
        $this->_headerText = Mage::helper('cms')->__('Static Blocks');
        $this->_addButtonLabel = Mage::helper('cms')->__('Add New Block');
        parent::__construct();
    }

}

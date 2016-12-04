<?php
class Mage_Document_Block_Adminhtml_Dir_Moveto extends Mage_Adminhtml_Block_Template
{
    /**
     * Define Form settings
     *
     */
    public function __construct()
    {
        parent::__construct();
        
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->setTemplate('document/dir/moveto.phtml');
    }
}

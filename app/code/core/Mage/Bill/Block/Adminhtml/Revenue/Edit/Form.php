<?php
class Mage_Bill_Block_Adminhtml_Revenue_Edit_Form extends Mage_Adminhtml_Block_Template
{
    /**
     * Define Form settings
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bill/revenue/form.phtml');
    }
}

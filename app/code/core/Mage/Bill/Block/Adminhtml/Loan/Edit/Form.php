<?php
class Mage_Bill_Block_Adminhtml_Loan_Edit_Form extends Mage_Adminhtml_Block_Template
{
    /**
     * Define Form settings
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bill/loan/form.phtml');
    }
}

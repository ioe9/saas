<?php
class Mage_Edm_Block_Adminhtml_Email_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
        
        Mage::app()->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        
      
    }
    
    protected function _prepareForm()
    {
        $form   = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'post',
            'enctype' => 'multipart/form-data'
        ));
        
        $form->setAction($this->getUrl('*/*/save'));
        $form->setUseContainer(false);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

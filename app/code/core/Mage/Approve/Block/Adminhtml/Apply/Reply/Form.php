<?php
class Mage_Approve_Block_Adminhtml_Approve_Reply_Form extends Mage_Adminhtml_Block_Widget_Form
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
        Mage::app()->getLayout()->getBlock('head')->setCanLoadCKEditor(true);
        $this->setIndividual(true);
    }
    
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form', 
            'action' => $this->getUrl('*/*/saveReview', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data')
        );
		$approve = Mage::registry('current_approve');
		$data = array('reply_approve'=>$approve->getId());
		
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '',
            'class'    => 'fieldset-wide first mb20',
        ));
       
        $fieldset->addField('reply_approve', 'hidden', array(
            'name'      => 'reply_approve',
        ));
        

       
        
        $fieldset->addField('reply_desc', 'textarea', array(
            'name'      => 'reply_desc',
            'label'     => '回复内容',
            'title'     => '回复内容',
            //'placeholder' => '添加回复',
            'required'  => true,
            'style' => 'height:200px;width:480px;',
        ));
        
        
        $fieldset->addField('reply_submit', 'button', array(
            'name'      => 'reply_submit',
            'label'     => '',
            'title'     => '',
            'class'     => 'btn btn-primary',
            'onclick'   => 'editForm.submit()',
            'required'  => false,
            
        ));
        $data['reply_submit'] = '发表回复';
        //上传附件
        $form->setUseContainer(true);
        
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

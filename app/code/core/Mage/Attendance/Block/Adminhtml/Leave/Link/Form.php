<?php
class Mage_Attendance_Block_Adminhtml_Leave_Link_Form extends Mage_Adminhtml_Block_Widget_Form
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
            'action' => $this->getUrl('*/*/saveLink', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data')
        );
		$leave = Mage::registry('current_leave');
		$data = array('link_object'=>$leave->getId());
		
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '',
            'class'    => 'fieldset-wide first mb20',
        ));
       
        $fieldset->addField('link_object', 'hidden', array(
            'name'      => 'link_object',
        ));
        

       
        
        $fieldset->addField('link_suggest', 'textarea', array(
            'name'      => 'link_suggest',
            'label'     => '回复内容',
            'title'     => '回复内容',
            'required'  => true,
            'style' => 'height:100px;width:480px;',
        ));
        
        
        $fieldset->addField('leave_submit', 'button', array(
            'name'      => 'leave_submit',
            'label'     => '',
            'title'     => '',
            'class'     => 'btn btn-primary',
            'onclick'   => 'editForm.submit()',
            'required'  => false,
            
        ));
        $data['leave_submit'] = '发表回复';
        //上传附件
        $form->setUseContainer(true);
        
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

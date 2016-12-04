<?php
class Mage_Edm_Block_Adminhtml_Client_Group_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
    	
        parent::__construct();

    }
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form', 
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post')
        );
		$model = Mage::registry('current_group');
		$data = $model->getData();
		$data['id'] = $data['group_id'];
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '',
            'class'    => 'fieldset-wide p20',
        ));
        if ($model->getId()) {
        	$fieldset->addField('id', 'hidden', array(
            'name'      => 'id',
            'required'  => true,
        ));
        }
        $fieldset->addField('group_name', 'text', array(
            'name'      => 'group_name',
            'label'     => '名称',
            'title'     => '名称',
            'required'  => true,
            'note' => '不多于100字',
           
        ));
        
        $contentField = $fieldset->addField('group_position', 'text', array(
            'name'      => 'group_position',
            'label'     => '排序',
            'title'     => '排序',
            'required'  => false,
            'note' => '填写整数',
        ));
        
        $contentField = $fieldset->addField('group_memo', 'textarea', array(
            'name'      => 'group_memo',
            'label'     => '备注',
            'title'     => '备注',
            'required'  => false,
            'style'	=> 'height:200px',
            'note' => '不多于1000字',
        ));
        
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
    
    public function getSubmitButton() {
    	return true;
    }
}

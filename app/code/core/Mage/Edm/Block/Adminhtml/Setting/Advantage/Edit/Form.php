<?php
class Mage_Edm_Block_Adminhtml_Setting_Advantage_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
            'class'    => 'fieldset-wide',
        ));
        if ($model->getId()) {
        	$fieldset->addField('id', 'hidden', array(
            'name'      => 'id',

            'required'  => true,
        ));
        }
        $fieldset->addField('group_name', 'text', array(
            'name'      => 'group_name',
            'label'     => '组名称',
            'title'     => '组名称',
            'required'  => true,
        ));
        $typeField = $fieldset->addField('group_type', 'select', array(
            'name'      => 'group_type',
            'label'     => '类型',
            'title'     => '类型',
            'required'  => false,
            'options' => $model->getTypeOptions(),
            'disabled'   => ($model->getId() ? true : false),
            'note' => '保存后不可更改',
        ));
        $fieldset->addField('group_status', 'select', array(
            'name'      => 'group_status',
            'label'     => '状态',
            'title'     => '状态',
            'required'  => false,
            
            'options' => $model->getStatusOptions(),
        ));
        $fieldset->addField('group_position', 'text', array(
            'name'      => 'group_position',
            'label'     => '排序',
            'title'     => '排序',
            'required'  => false,
            'note' => '请填写整数',
        ));
        $fieldset->addField('group_memo', 'textarea', array(
            'name'      => 'group_memo',
            'label'     => '备注',
            'title'     => '备注',
            'required'  => false,
            'style'		=> 'height:60px;',
        ));
        $contentField = $fieldset->addField('group_content', 'editor', array(
            'name'      => 'group_content',
            'label'     => '内容',
            'title'     => '内容',
            'required'  => false,
            'style'		=> 'height:200px;',
            'note' => '类型为“自定义”时有效',
        ));
        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
	            ->addFieldMap($contentField->getHtmlId(), $contentField->getName())
	            ->addFieldMap($typeField->getHtmlId(), $typeField->getName())
	            ->addFieldDependence(
	                $contentField->getName(),
	                $typeField->getName(),
	                Mage_Edm_Model_Company_Advantage_Group::TYPE_CUSTOM));
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

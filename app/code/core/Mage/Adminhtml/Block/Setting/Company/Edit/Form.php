<?php
class Mage_Adminhtml_Block_Setting_Company_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('current_company');
        $data  = $model->getData();
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form', 
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data')
        );
        $data['id'] = $data['company_id'];
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '',
            'class'    => 'fieldset-short first mb20',
        ));
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
            ));
        }

		$fieldset->addField('company_logo', 'image', array(
            'name'      => 'company_logo',
            'label'     => '企业Logo',
            'title'     => '企业Logo',
            'required'  => false,
        ));
        $fieldset->addField('company_name', 'text', array(
            'name'      => 'company_name',
            'label'     => '企业名称',
            'title'     => '企业名称',
            'required'  => true,
        ));
        $fieldset->addField('company_industry', 'select', array(
            'name'      => 'company_industry',
            'label'     => '企业类型',
            'title'     => '企业类型',
            //'values'   => Mage::getSingleton('company/type')->getAsOptionsArray(),
            'values' => array(array('label'=>'其他','value'=>'0')),
			'required'  => false,
        ));
         $fieldset->addField('company_contact', 'text', array(
            'name'      => 'company_phone',
            'label'     => '联系人',
            'title'     => '联系人',
            'required'  => false,
        ));
        $fieldset->addField('company_phone', 'text', array(
            'name'      => 'company_phone',
            'label'     => '联系电话',
            'title'     => '联系电话',
            'required'  => false,
        ));
        $fieldset   = $form->addFieldset('base_fieldset_copy', array(
            'legend'    => '更多详细信息',
            'class'    => 'fieldset-short mb20',
        ));
		$fieldset->addField('street', 'textarea', array(
            'name'      => 'street',
            'label'     => '公司地址',
            'title'     => '公司地址',
            'style' => 'height:60px;width:320px;',
            'required'  => false,
        ));
		
        $fieldset->addField('postcode', 'text', array(
            'name'      => 'postcode',
            'label'     => '邮编',
            'title'     => '邮编',
            'required'  => false,
        ));
       
        $fieldset->addField('company_website', 'text', array(
            'name'      => 'company_website',
            'label'     => '企业官网',
            'title'     => '企业官网',
            'required'  => false,
        ));
        $fieldset->addField('company_desc', 'textarea', array(
            'name'      => 'company_desc',
            'label'     => '企业介绍',
            'title'     => '企业介绍',
            'required'  => false,
            'style' => 'height:200px;width:320px;',
        ));
        

        $form->setValues($data);
        
        $form->setUseContainer(true);
        $form->setId('edit_form');

        $this->setForm($form);

        return parent::_prepareForm();
    }
}

<?php
class Mage_Edm_Block_Adminhtml_Setting_Info_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
    }
    
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$model = Mage::registry('current_edm_company');
		$data = $model->getData();
		if ($model->getId()) {
			//已设置过信息
		} else {
			//未设置过信息
		}
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '',
            'class'    => '',
        ));
        $fieldset->addField('company_logo', 'image', array(
            'name'      => 'company_logo',
            'label'     => 'LOGO',
            'title'     => 'LOGO',
            'required'  => false,
            'note'	=> '邮件里展示的LOGO',
        ));
        $fieldset->addField('company_name', 'text', array(
            'name'      => 'company_name',
            'label'     => '公司名称',
            'title'     => '公司名称',
            'required'  => false,
            'note'	=> '邮件里对外展示的名称',
        ));
        $fieldset->addField('company_contact', 'text', array(
            'name'      => 'company_contact',
            'label'     => '联系人',
            'title'     => '联系人',
            'required'  => false,
            'note'	=> '默认邮件联系人',
        ));
        $fieldset->addField('company_email', 'text', array(
            'name'      => 'company_email',
            'label'     => '联系邮箱',
            'title'     => '联系邮箱',
            'required'  => false,
            'note'	=> '默认邮件联系邮箱',
        ));
        $fieldset->addField('company_website', 'text', array(
            'name'      => 'company_website',
            'label'     => '官网',
            'title'     => '官网',
            'required'  => false,
            'note'	=> '如：http://www.ioe6.com/',
        ));
        
        $fieldset->addField('company_address', 'text', array(
            'name'      => 'company_address',
            'label'     => '通讯地址',
            'title'     => '通讯地址',
            'required'  => false,
        ));
        $fieldset->addField('company_zip', 'text', array(
            'name'      => 'company_zip',
            'label'     => '邮编',
            'title'     => '邮编',
            'required'  => false,
        ));
        $fieldset->addField('about', 'textarea', array(
            'name'      => 'about',
            'label'     => '公司简介',
            'title'     => '公司简介',
            'required'  => false,
            'style' => 'height:100px',
        ));
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

<?php
class Mage_Edm_Block_Adminhtml_Email_Edit_Company_Base extends Mage_Adminhtml_Block_Widget_Form
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
		$model = Mage::registry('current_company');
		$data = $model->getData();
		$data['id'] = $data['company_id'];
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '帐号基本信息设置',
            'class'    => 'fieldset-wide',
        ));
       
        $fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => '公司名称',
            'title'     => '公司名称',
            'required'  => false,
        ));
        $fieldset->addField('contact_person', 'text', array(
            'name'      => 'contact_person',
            'label'     => '联系人',
            'title'     => '联系人',
            'required'  => false,
        ));
        $fieldset->addField('contact_email', 'text', array(
            'name'      => 'contact_email',
            'label'     => '联系邮箱',
            'title'     => '联系邮箱',
            'required'  => false,
        ));
        $fieldset->addField('website', 'text', array(
            'name'      => 'website',
            'label'     => '官网',
            'title'     => '官网',
            'required'  => false,
        ));
        /*
        $fieldset->addField('category_a', 'multiselect', array(
            'name'      => 'category_a',
            'label'     => '产品大类',
            'title'     => '产品大类',
            'values'      => Mage::getModel('edm/product_category')->getCategoriesMulitiOption(1,true),
            'required'  => false,
            'size'  => '5',
            'style' => 'height:100px'
           
        ));
        if ($model) {
        	$cats = Mage::getResourceModel('edm/company_category_collection')
				->addFieldToFilter('company_id',$model->getId());
        }
		      
		//$catOldIds = implode(',',$cats->getAllIds());	
		$catOldIds = array();
		foreach ($cats as $_cat) {
			array_push($catOldIds,$_cat->getCategoryId());
		}
		$fieldset->addField('category_b', 'multiselect', array(
            'name'      => 'category_b',
            'label'     => '产品二级类别',
            'title'     => '产品二级类别',
            'values'    => Mage::getModel('edm/product_category')->getSecondMulitiOption(),
            'required'  => false,
            'size'  => '5',
            'style' => 'height:100px'
        ));
        $data['category_a'] = $catOldIds;
        $data['category_b'] = $catOldIds;*/
        /*
        $fieldset->addField('province', 'select', array(
            'name'      => 'province',
            'label'     => '省份',
            'title'     => '省份',
            'required'  => false,
            'options'     => array(),
        ));
        $fieldset->addField('city', 'select', array(
            'name'      => 'city',
            'label'     => '城市',
            'title'     => '城市',
            'required'  => false,
            'options'     => array(),
        ));
        $fieldset->addField('street', 'text', array(
            'name'      => 'street',
            'label'     => '街道地址',
            'title'     => '街道地址',
            'required'  => false,
        ));
        $fieldset->addField('zip', 'text', array(
            'name'      => 'zip',
            'label'     => '邮编',
            'title'     => '邮编',
            'required'  => false,
        ));
        $fieldset->addField('about', 'editor', array(
            'name'      => 'about',
            'label'     => '公司介绍',
            'title'     => '公司介绍',
            'required'  => false,
            'style' => 'height:200px',
        ));*/
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

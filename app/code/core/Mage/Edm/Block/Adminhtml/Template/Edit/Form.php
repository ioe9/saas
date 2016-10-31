<?php
class Mage_Edm_Block_Adminhtml_Template_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form', 
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data')
        );
		$model = Mage::registry('current_template');
		$data = $model->getData();
		$data['id'] = $data['template_id'];
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '基本信息设置',
            'class'    => 'fieldset-wide',
        ));
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
            ));
        }
        $fieldset->addField('category_id', 'select', array(
            'name'      => 'url',
            'label'     => '所属分类',
            'title'     => '所属分类',
            'required'  => false,
            'options'   => Mage::getModel('edm/template_category')->getCategoriesOption(),
        ));
        $fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => '名称',
            'title'     => '名称',
            'required'  => true,
        ));
        $fieldset->addField('sku', 'text', array(
            'name'      => 'sku',
            'label'     => 'SKU',
            'title'     => 'SKU',
            'required'  => false,
        ));
        $fieldset->addField('price', 'text', array(
            'name'      => 'price',
            'label'     => '价格',
            'title'     => '价格',
            'required'  => false,
        ));
        $fieldset->addField('special_price', 'text', array(
            'name'      => 'special_price',
            'label'     => '特价',
            'title'     => '特价',
            'required'  => false,
        ));
        
        $fieldset->addField('image', 'image', array(
            'name'      => 'image',
            'label'     => '邮件模板主图',
            'title'     => '邮件模板主图',
            'required'  => false,
        ));
        $fieldset->addField('position', 'text', array(
            'name'      => 'position',
            'label'     => '排序',
            'title'     => '排序',
            'required'  => false,
        ));
        $fieldset->addField('url', 'text', array(
            'name'      => 'url',
            'label'     => '链接',
            'title'     => '链接',
            'required'  => false,
        ));
        $fieldset->addField('status', 'select', array(
            'name'      => 'url',
            'label'     => '状态',
            'title'     => '状态',
            'required'  => false,
            'options'   => array('0'=>'禁用','1'=>'启用'),
        ));
		
        $fieldset->addField('sdesc', 'textarea', array(
            'name'      => 'sdesc',
            'label'     => '简介',
            'title'     => '简介',
            'required'  => false,
            'style' => 'height:80px',
            
        ));
        $fieldset->addField('desc', 'editor', array(
            'name'      => 'desc',
            'label'     => '详细描述',
            'title'     => '详细描述',
            'required'  => false,
            'style' => 'height:400px',
            
        ));
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

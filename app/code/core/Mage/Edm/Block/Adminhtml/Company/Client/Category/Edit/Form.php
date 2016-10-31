<?php
class Mage_Edm_Block_Adminhtml_Company_Client_Category_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
		$model = Mage::registry('current_category');
		$data = $model->getData();
		$data['id'] = $model->getId();
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => ('分组信息设置'),
            'class'    => 'fieldset-wide',
        ));
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
                'value'     => $model->getId(),
            ));
        }

        $fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => ('分组名称'),
            'title'     => ('分组名称'),
            'required'  => false,
        ));
		$fieldset->addField('parent_id', 'select', array(
            'name'      => 'parent_id',
            'label'     => ('父分组'),
            'title'     => ('父分组'),
            'required'  => false,
            'options'     => Mage::getModel('edm/company_client_category')->getCategoriesOption($data['id']), 
        ));

        $fieldset->addField('status', 'select', array(
            'name'      => 'status',
            'label'     => ('是否启用'),
            'title'     => ('是否启用'),
            'required'  => false,
            'options'     => array('1'=>'Enable','0'=>'Disable'),
             
        ));
        $fieldset->addField('is_hot', 'select', array(
            'name'      => 'is_hot',
            'label'     => '是否推荐',
            'title'     => '是否推荐',
            'required'  => false,
            'options'     => array('1'=>'Yes','0'=>'No'), 
        ));
        $fieldset->addField('position', 'text', array(
            'name'      => 'position',
            'label'     => ('排序'),
            'title'     => ('排序'),
            'required'  => false,

             
        ));
        $fieldset->addField('desc', 'textarea', array(
            'name'      => 'desc',
            'label'     => ('简要描述'),
            'title'     => ('简要描述'),
            'required'  => false,
        ));

        $form->setValues($data);
        $form->setAction($this->getUrl('*/*/save'));
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

<?php
class Mage_Edm_Block_Adminhtml_Urlprocess_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
			)
        );

        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '基本信息设置',
            'class'    => 'fieldset-wide',
        ));
       
        $fieldset->addField('urls', 'textarea', array(
            'name'      => 'urls',
            'label'     => 'URL列表',
            'title'     => 'URL列表',
            'required'  => true,
            'after_element_html' => '<br/>注意：以换行分隔多条记录',
        ));
        $fieldset->addField('position', 'text', array(
            'name'      => 'position',
            'label'     => '优先度',
            'title'     => '优先度',
            'required'  => false,
            'after_element_html' => '<br/>注意：输入整数；如果你多次提交URL，优先度大的优先处理',
        ));
       /*
        $fieldset->addField('is_active', 'select', array(
            'name'      => 'is_active',
            'label'     => '立即提交处理',
            'title'     => '立即提交处理',
            'required'  => false,
            'options'   => array('0'=>'是','1'=>'否'),
        ));*/
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

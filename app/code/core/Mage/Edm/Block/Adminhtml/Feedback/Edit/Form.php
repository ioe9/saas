<?php
class Mage_Edm_Block_Adminhtml_Feedback_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
		$model = Mage::registry('current_feedback');
		$data = $model->getData();
		$data['id'] = $data['feedback_id'];
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
        $fieldset->addField('feedback_title', 'text', array(
            'name'      => 'feedback_title',
            'label'     => '标题',
            'title'     => '标题',
            'required'  => true,
            'note' => '请填写合适的标题，便于客服快速处理',
        ));
        
        $contentField = $fieldset->addField('feedback_content', 'editor', array(
            'name'      => 'feedback_content',
            'label'     => '反馈内容',
            'title'     => '反馈内容',
            'required'  => false,
            'note' => '不多余1000字',
        ));
        
        $fieldset->addField('feedback_image', 'image', array(
            'name'      => 'feedback_image',
            'label'     => '图片1',
            'title'     => '图片1',
            'required'  => false,
            'note' => '',
        ));
        $fieldset->addField('feedback_image2', 'image', array(
            'name'      => 'feedback_image2',
            'label'     => '图片2',
            'title'     => '图片2',
            'required'  => false,
            'note' => '',
        ));
        $fieldset->addField('feedback_image3', 'image', array(
            'name'      => 'feedback_image3',
            'label'     => '图片3',
            'title'     => '图片3',
            'required'  => false,
            'note' => '',
        ));
        
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

<?php
class Mage_Task_Block_Adminhtml_Task_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
		$model = Mage::registry('current_task');
		$data = $model->getData();
		$data['id'] = $data['task_id'];
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '基本信息设置',
            'class'    => 'fieldset-wide',
        ));
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
            ));
        }

        $fieldset->addField('task_name', 'text', array(
            'name'      => 'task_name',
            'label'     => '任务名称',
            'title'     => '任务名称',
            'required'  => true,
        ));
        $fieldset->addField('task_project', 'select', array(
            'name'      => 'task_project',
            'label'     => '所属项目',
            'title'     => '所属项目',
            'values'   => Mage::getSingleton('task/project')->getAsOptions(),
            'required'  => true,
        ));

		$fieldset->addField('date_from', 'text', array(
            'name'      => 'date_from',
            'label'     => '启动时间',
            'title'     => '启动时间',
            'required'  => true,
        ));
        $fieldset->addField('date_to', 'text', array(
            'name'      => 'date_to',
            'label'     => '启动时间',
            'title'     => '启动时间',
            'required'  => true,
        ));
       
       
        $fieldset->addField('task_level','select', array(
            'name'    => "task_level",
            'label'     => '优先级',
            'title'     => '优先级',
            'values'   => Mage::getSingleton('task/task')->getLevelOptions(),
        ));
        $fieldset->addField('task_charge', 'text', array(
            'name'      => 'task_charge',
            'label'     => '责任人',
            'title'     => '责任人',
            'required'  => true,
        ));
        $fieldset->addField('task_focus', 'text', array(
            'name'      => 'task_focus',
            'label'     => '抄送人',
            'title'     => '抄送人',
            'required'  => false,
        ));
        $fieldset->addField('task_audit', 'text', array(
            'name'      => 'task_audit',
            'label'     => '验收人',
            'title'     => '验收人',
            'required'  => false,
        ));
        $fieldset->addField('task_desc', 'editor', array(
            'name'      => 'task_desc',
            'label'     => '任务描述',
            'title'     => '任务描述',
            'required'  => true,
        ));
        
        //上传附件
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

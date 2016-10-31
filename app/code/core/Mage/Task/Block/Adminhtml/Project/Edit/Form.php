<?php
class Mage_Task_Block_Adminhtml_Project_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
        Mage::app()->getLayout()->getBlock('head')->setCanLoadCKEditor(true);
    }
    
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form', 
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data')
        );
		$model = Mage::registry('current_project');
		$data = $model->getData();
		$data['id'] = $data['project_id'];
        $fieldset   = $form->addFieldset('base_fieldset', array(
            //'legend'    => '基本信息设置',
            'class'    => 'first',
        ));
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
            ));
        }

        $fieldset->addField('project_name', 'text', array(
            'name'      => 'project_name',
            'label'     => '项目名称',
            'title'     => '项目名称',
            'required'  => true,
        ));
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
            array('tab_id' => $this->getTabId())
        );
        $fieldset->addField('project_desc', 'editor', array(
            'name'      => 'project_desc',
            'label'     => '项目描述',
            'title'     => '项目描述',
            'required'  => true,
            'config'    => $wysiwygConfig
        ));
       
		
        $fieldset   = $form->addFieldset('base_fieldset2', array(
            //'legend'    => '基本信息设置',
            'class'    => '',
        ));
        $fieldset->addField('is_private','radios', array(
            'name'    => "is_private",
            'label'     => '是否公开',
            'title'     => '是否公开',
            
            'values'   => Mage::getSingleton('task/project')->getPrivateOptionsArray(),
        ));
        $fieldset->addField('project_admin', 'text', array(
            'name'      => 'project_admin',
            'label'     => '管理员设置',
            'title'     => '管理员设置',
            'note'		=> '管理员可以设置项目属性，并具有任务的所有权限',
            'required'  => false,
        ));
        $fieldset   = $form->addFieldset('base_fieldset3', array(
            //'legend'    => '基本信息设置',
            'class'    => 'last',
        ));
        $fieldset->addField('project_publish', 'text', array(
            'name'      => 'project_publish',
            'label'     => '任务发布人',
            'title'     => '任务发布人',
            'note'		=> '设定任务发布人，则只有发布人可以在该项目新建任务，不设定则不限制',
            'required'  => false,
        ));
        $fieldset->addField('project_audit', 'text', array(
            'name'      => 'project_audit',
            'label'     => '任务验收人',
            'title'     => '任务验收人',
            'note'		=> '设定任务验收人，则只有验收人可以关闭任务，不设定则不限制',
            'required'  => false,
        ));
        
        
        //上传附件
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

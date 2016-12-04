<?php
class Mage_Document_Block_Adminhtml_Dir_Form extends Mage_Adminhtml_Block_Widget_Form
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
        $this->setData('enableChooser',true);
        $this->setTemplate('document/dir/form.phtml');

    }
    
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form', 
            'action' => $this->getUrl('*/*/saveDir', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'class' => 'ajax-submit')
        );
		$model = Mage::registry('current_dir');
		$data = $model->getData();
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '',
            'class'    => 'fieldset-wide',
        ));
        
        $fieldset->addField('dir_name', 'text', array(
            'name'      => 'dir_name',
            'label'     => '文件夹名',
            'title'     => '文件夹名',
            'required'  => true,
        ));
        if (!$model->getId()) {
        	$fieldset->addField('dir_parent', 'hidden', array(
	            'name'      => 'dir_parent',
	        ));
	        $data['dir_parent'] = Mage::registry('current_dir_parent');
        } else {
        	$fieldset->addField('dir_id', 'hidden', array(
	            'name'      => 'dir_id',
	        ));
        }
        

        $fieldset->addField('visible_scope', 'radios', array(
            'name'      => 'visible_scope',
            'label'     => '可见范围',
            'title'     => '可见范围',
            'values'    => array(
            	array('value'=>'0','label'=>'公开'),
            	array('value'=>'1','label'=>'仅自己')
            ),
            'required'  => false,
        ));
        
        if ($model->getId()) {
        	$deptData = Mage::getModel('document/dir_link')->getDeptChooserSelected($model->getId());
        	$userData = Mage::getModel('document/dir_link')->getUserdChooserSelected($model->getId());
        	$deptArr = array();
        	$userArr = array();
        	foreach ($deptData as $item) {
        		array_push($deptArr,$item['id']);
        	}
        	$data['visible_department'] = implode(',',$deptArr);
        	$data['visible_department_old'] = implode(',',$deptArr);
        	foreach ($userData as $item) {
        		array_push($userArr,$item['id']);
        	}
        	$data['visible_user'] = implode(',',$userArr);
        	$data['visible_user_old'] = implode(',',$userArr);
        } else {
        	$deptData = array();
        	$data['visible_scope'] = 0;
        }
        
        $fieldset->addField('visible_department_old', 'hidden', array(
            'name'      => 'visible_department_old',
            'required'  => false,
        ));
        
        $fieldset->addField('visible_department', 'text', array(
            'name'      => 'visible_department',
            'label'     => '可见部门',
            'title'     => '可见部门',
			'class'     => 'input-user',
            'required'  => false,
            'after_element_html' => '<div class="input-user-wrap"><div class="inner" id="visible_department_tag"></div><a href="javascript:;" onclick="openTreechooser(this,\'dept\');" data-tag="visible_department_tag" data-target="visible_department" data-old=\''.json_encode($deptData).'\' class="add-user"><i class="fa fa-plus f-right"></i></a></div>',
        ));
        $fieldset->addField('visible_user_old', 'hidden', array(
            'name'      => 'visible_user_old',
            'required'  => false,
        ));
        $fieldset->addField('visible_user', 'text', array(
            'name'      => 'visible_user',
            'label'     => '可见人员',
            'title'     => '可见人员',
            'class'     => 'input-user',
            'required'  => false,
            'after_element_html' => '<div class="input-user-wrap"><div class="inner" id="visible_user_tag"></div><a href="javascript:;" onclick="openTreechooser(this);" data-tag="visible_user_tag" data-target="visible_user" data-old=\''.json_encode($userData).'\' class="add-user"><i class="fa fa-plus f-right"></i></a></div>',
        ));
        
        
        
        $fieldset->addField('buttons', 'note', array(
            'name'      => 'buttons',

            'class'     => 'buttons',
            'required'  => false,
            'after_element_html' => '<button type="button" class="btn btn-primary mr20 wp40" onclick="editForm.submit();">保存</button><button type="button" class="btn btn-default wp40 btn-dialog-cancel">取消</button>',
        ));
        
        
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

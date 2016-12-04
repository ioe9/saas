<?php
class Mage_Attendance_Block_Adminhtml_Fieldwork_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form', 
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data')
        );
		$model = Mage::registry('current_fieldwork');
		$data = $model->getData();
		$data['id'] = $data['fieldwork_id'];
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '',
            'class'    => 'fieldset-wide first mb20',
        ));
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
            ));
        }

		$fieldset->addField('fieldwork_create', 'text', array(
            'name'      => 'fieldwork_create',
            'label'     => '申请人',
            'title'     => '申请人',

            'disabled'  => true,
           
        ));
        $data['fieldwork_create'] = Mage::registry('current_user')->getName();
       
        $fieldset->addField('fieldwork_department', 'hidden', array(
            'name'      => 'fieldwork_department',
        ));
        $fieldset->addField('fieldwork_department_copy', 'text', array(
            'name'      => 'fieldwork_department_copy',
            'label'     => '部门',
            'title'     => '部门',
            'disabled'  => true,
        ));
        $data['fieldwork_department'] = Mage::registry('current_user')->getDepartment()->getId();
        $data['fieldwork_department_copy'] = Mage::registry('current_user')->getDepartment()->getDepName();
       
        $fieldset->addField('date_from', 'text', array(
            'name'      => 'date_from',
            'label'     => '开始时间',
            'title'     => '开始时间',
            'required'  => true,
        ));
        $fieldset->addField('date_to', 'text', array(
            'name'      => 'date_to',
            'label'     => '结束时间',
            'title'     => '结束时间',
            'required'  => true,
        ));
        $fieldset->addField('fieldwork_hour', 'text', array(
            'name'      => 'fieldwork_hour',
            'label'     => '时长',
            'title'     => '时长',
            'required'  => true,
        ));
        $fieldset->addField('fieldwork_address', 'text', array(
            'name'      => 'fieldwork_address',
            'label'     => '地点',
            'title'     => '地点',
            'required'  => true,
        ));
        if (!$model->getId()) {
        	$data['date_create'] = Mage::getSingleton('core/date')->gmtDate('Y-m-d H:i');
        }
        $fieldset->addField('fieldwork_reason', 'editor', array(
            'name'      => 'fieldwork_reason',
            'label'     => '原因',
            'title'     => '原因',
            'required'  => true,
            'style' => 'height:150px;width:480px;',
        ));
        
       if ($model->getId()) {
        	$auditData = Mage::getModel('attendance/fieldwork_link')->getLinkedChooserSelected($model->getId());
        	$ccData = Mage::getModel('attendance/fieldwork_link')->getLinkedChooserSelected($model->getId(),Mage_Attendance_Model_Fieldwork_Link::LINK_TYPE_CC);
        	$auditArr = array();
        	$ccArr = array();
        	foreach ($auditData as $item) {
        		array_push($auditArr,$item['id']);
        	}
        	$data['fieldwork_audit'] = implode(',',$auditArr);
        	$data['fieldwork_audit_old'] = implode(',',$auditArr);
        	foreach ($ccData as $item) {
        		array_push($ccArr,$item['id']);
        	}
        	$data['fieldwork_cc'] = implode(',',$ccArr);
        	$data['fieldwork_cc_old'] = implode(',',$ccArr);
        } else {
        	$auditData = array();
        }
        
        $fieldset->addField('fieldwork_audit_old', 'hidden', array(
            'name'      => 'fieldwork_audit_old',
            'required'  => false,
        ));
        
        $fieldset->addField('fieldwork_audit', 'text', array(
            'name'      => 'fieldwork_audit',
            'label'     => '审批人',
            'title'     => '审批人',
			'class'     => 'input-user',
            'required'  => true,
            'after_element_html' => '<div class="input-user-wrap"><div class="inner" id="fieldwork_audit_tag"></div><a href="javascript:;" onclick="openTreechooser(this);" data-tag="fieldwork_audit_tag" data-target="fieldwork_audit" data-old=\''.json_encode($auditData).'\' class="add-user"><i class="fa fa-plus f-right"></i></a></div>',
        ));
        $fieldset->addField('fieldwork_cc_old', 'hidden', array(
            'name'      => 'fieldwork_cc_old',
            'required'  => false,
        ));
        $fieldset->addField('fieldwork_cc', 'text', array(
            'name'      => 'fieldwork_cc',
            'label'     => '抄送人',
            'title'     => '抄送人',
            'class'     => 'input-user',
            'required'  => false,
            'after_element_html' => '<div class="input-user-wrap"><div class="inner" id="fieldwork_cc_tag"></div><a href="javascript:;" onclick="openTreechooser(this);" data-tag="fieldwork_cc_tag" data-target="fieldwork_cc" data-old=\''.json_encode($ccData).'\' class="add-user"><i class="fa fa-plus f-right"></i></a></div>',
        ));
        
        //上传附件
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

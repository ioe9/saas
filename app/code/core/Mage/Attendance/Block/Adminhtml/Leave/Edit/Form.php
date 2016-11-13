<?php
class Mage_Attendance_Block_Adminhtml_Leave_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
		$model = Mage::registry('current_leave');
		$data = $model->getData();
		$data['id'] = $data['leave_id'];
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '',
            'class'    => 'fieldset-wide first mb20',
        ));
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
            ));
        }

		$fieldset->addField('leave_create', 'text', array(
            'name'      => 'leave_create',
            'label'     => '申请人',
            'title'     => '申请人',

            'disabled'  => true,
           
        ));
        $data['leave_create'] = Mage::registry('current_user')->getName();
       
        $fieldset->addField('leave_department', 'hidden', array(
            'name'      => 'leave_department',
        ));
        $fieldset->addField('leave_department_copy', 'text', array(
            'name'      => 'leave_department_copy',
            'label'     => '部门',
            'title'     => '部门',
            'disabled'  => true,
        ));
        $data['leave_department'] = Mage::registry('current_user')->getDepartment()->getId();
        $data['leave_department_copy'] = Mage::registry('current_user')->getDepartment()->getDepName();
       
        $fieldset->addField('leave_type', 'select', array(
            'name'      => 'leave_type',
            'label'     => '假类',
            'title'     => '假类',
            //'required'  => true,
            //'options'   => Mage::getModel('attendance/setting_type')->getAsOptions(),
            'option' => array(),
        ));
        $fieldset->addField('leave_hour', 'text', array(
            'name'      => 'leave_hour',
            'label'     => '时长',
            'title'     => '时长',
            'required'  => true,
        ));
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
        

        if (!$model->getId()) {
        	$data['date_create'] = Mage::getSingleton('core/date')->gmtDate('Y-m-d H:i');
        }
        $fieldset->addField('leave_reason', 'editor', array(
            'name'      => 'leave_reason',
            'label'     => '请假原因',
            'title'     => '请假原因',
            'required'  => true,
            'style' => 'height:150px;width:480px;',
        ));
        
       if ($model->getId()) {
        	$auditData = Mage::getModel('attendance/leave_link')->getLinkedChooserSelected($model->getId());
        	$ccData = Mage::getModel('attendance/leave_link')->getLinkedChooserSelected($model->getId(),Mage_Attendance_Model_Leave_Link::LINK_TYPE_CC);
        	$auditArr = array();
        	$ccArr = array();
        	foreach ($auditData as $item) {
        		array_push($auditArr,$item['id']);
        	}
        	$data['leave_audit'] = implode(',',$auditArr);
        	$data['leave_audit_old'] = implode(',',$auditArr);
        	foreach ($ccData as $item) {
        		array_push($ccArr,$item['id']);
        	}
        	$data['leave_cc'] = implode(',',$ccArr);
        	$data['leave_cc_old'] = implode(',',$ccArr);
        } else {
        	$auditData = array();
        }
        
        $fieldset->addField('leave_audit_old', 'hidden', array(
            'name'      => 'leave_audit_old',
            'required'  => false,
        ));
        
        $fieldset->addField('leave_audit', 'text', array(
            'name'      => 'leave_audit',
            'label'     => '审批人',
            'title'     => '审批人',
			'class'     => 'input-user',
            'required'  => true,
            'after_element_html' => '<div class="input-user-wrap"><div class="inner" id="leave_audit_tag"></div><a href="javascript:;" onclick="openTreechooser(this);" data-tag="leave_audit_tag" data-target="leave_audit" data-old=\''.json_encode($auditData).'\' class="add-user"><i class="fa fa-plus f-right" aria-hidden="true"></i></a></div>',
        ));
        $fieldset->addField('leave_cc_old', 'hidden', array(
            'name'      => 'leave_cc_old',
            'required'  => false,
        ));
        $fieldset->addField('leave_cc', 'text', array(
            'name'      => 'leave_cc',
            'label'     => '抄送人',
            'title'     => '抄送人',
            'class'     => 'input-user',
            'required'  => false,
            'after_element_html' => '<div class="input-user-wrap"><div class="inner" id="leave_cc_tag"></div><a href="javascript:;" onclick="openTreechooser(this);" data-tag="leave_cc_tag" data-target="leave_cc" data-old=\''.json_encode($ccData).'\' class="add-user"><i class="fa fa-plus f-right" aria-hidden="true"></i></a></div>',
        ));
        
        //上传附件
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

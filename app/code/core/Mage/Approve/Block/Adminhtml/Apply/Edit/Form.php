<?php
class Mage_Approve_Block_Adminhtml_Apply_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
		$model = Mage::registry('current_apply');
		$data = $model->getData();
		$data['id'] = $data['apply_id'];
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '',
            'class'    => 'fieldset-wide first mb20',
        ));
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
            ));
        }
		$fieldset->addField('apply_type', 'select', array(
            'name'      => 'apply_type',
            'label'     => '申请类型',
            'title'     => '申请类型',
            'values'   => Mage::getSingleton('approve/template')->getAsOptions(),
            'required'  => true,
        ));
        
        

		$fieldset->addField('apply_create', 'text', array(
            'name'      => 'apply_create',
            'label'     => '申请人',
            'title'     => '申请人',

            'disabled'  => true,
           
        ));
        $data['apply_create'] = Mage::registry('current_user')->getName();
       
        $fieldset->addField('apply_department', 'hidden', array(
            'name'      => 'apply_department',
        ));
        $fieldset->addField('apply_department_copy', 'text', array(
            'name'      => 'apply_department_copy',
            'label'     => '部门',
            'title'     => '部门',
            'disabled'  => true,
        ));
        $data['apply_department'] = Mage::registry('current_user')->getDepartment()->getId();
        $data['apply_department_copy'] = Mage::registry('current_user')->getDepartment()->getDepName();
       
        $fieldset->addField('apply_mobile', 'text', array(
            'name'      => 'apply_mobile',
            'label'     => '电话',
            'title'     => '电话',
			
        ));
        $fieldset->addField('date_create', 'text', array(
            'name'      => 'date_create',
            'label'     => '申请时间',
            'title'     => '申请时间',

            'disabled'  => true,
        ));
        if (!$model->getId()) {
        	$data['date_create'] = Mage::getSingleton('core/date')->gmtDate('Y-m-d H:i');
        }
        $fieldset->addField('apply_desc', 'editor', array(
            'name'      => 'apply_desc',
            'label'     => '详情',
            'title'     => '详情',
            'required'  => true,
            'style' => 'height:150px;width:480px;',
        ));
        
        if ($model->getId()) {
        	$auditData = Mage::getModel('approve/apply_link')->getLinkedChooserSelected($model->getId());
        	$ccData = Mage::getModel('approve/apply_link')->getLinkedChooserSelected($model->getId(),Mage_Approve_Model_Apply_Link::LINK_TYPE_CC);
        	$chargeArr = array();
        	$ccArr = array();
        	foreach ($auditData as $item) {
        		array_push($chargeArr,$item['id']);
        	}
        	$data['apply_audit'] = implode(',',$chargeArr);
        	$data['apply_audit_old'] = implode(',',$chargeArr);
        	foreach ($ccData as $item) {
        		array_push($ccArr,$item['id']);
        	}
        	$data['apply_cc'] = implode(',',$ccArr);
        	$data['apply_cc_old'] = implode(',',$ccArr);
        } else {
        	$auditData = array();
        	$ccArr = array();
        }
        $fieldset->addField('apply_audit', 'text', array(
            'name'      => 'apply_audit',
            'label'     => '审批人',
            'title'     => '审批人',
			'class'     => 'input-user',
            'required'  => true,
            'after_element_html' => '<div class="input-user-wrap"><div class="inner" id="apply_audit_tag"></div><a href="javascript:;" onclick="openTreechooser(this);" data-tag="apply_audit_tag" data-target="apply_audit" data-old=\''.json_encode($auditData).'\' class="add-user"><i class="fa fa-plus f-right"></i></a></div>',
        ));
        
        $fieldset->addField('apply_cc', 'text', array(
            'name'      => 'apply_cc',
            'label'     => '抄送人',
            'title'     => '抄送人',
			'class'     => 'input-user',
            'required'  => true,
            'after_element_html' => '<div class="input-user-wrap"><div class="inner" id="apply_cc_tag"></div><a href="javascript:;" onclick="openTreechooser(this);" data-tag="apply_cc_tag" data-target="apply_cc" data-old=\''.json_encode($ccData).'\' class="add-user"><i class="fa fa-plus f-right"></i></a></div>',
        ));
        //上传附件
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

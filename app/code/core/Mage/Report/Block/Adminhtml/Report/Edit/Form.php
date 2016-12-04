<?php
class Mage_Report_Block_Adminhtml_Report_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
		$model = Mage::registry('current_report');
		$data = $model->getData();
		$data['id'] = $data['report_id'];
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => '',
            'class'    => 'fieldset-wide first mb20',
        ));
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
            ));
        }

        $fieldset->addField('report_name', 'text', array(
            'name'      => 'report_name',
            'label'     => '报告标题',
            'title'     => '报告标题',
            'required'  => true,
        ));
        $fieldset->addField('report_type', 'select', array(
            'name'      => 'report_type',
            'label'     => '报告类型',
            'title'     => '报告类型',
            'values'   => Mage::getSingleton('report/type')->getAsOptionsArray(),
            'required'  => true,
        ));

		$fieldset->addField('report_creator', 'text', array(
            'name'      => 'report_creator',
            'label'     => '报告人',
            'title'     => '报告人',
            'required'  => true,
            'disabled'  => true,
           
        ));
        $data['report_creator'] = Mage::registry('current_user')->getName();
       
        $fieldset->addField('date_create', 'text', array(
            'name'      => 'date_create',
            'label'     => '报告时间',
            'title'     => '报告时间',
            'required'  => true,
            'disabled'  => true,
        ));
        if (!$model->getId()) {
        	$data['date_create'] = Mage::getSingleton('core/date')->gmtDate('Y-m-d');
        	
        	//$data['date_report'] = date('Y-m-d H:i:s');
        }
        if ($model->getId()) {
        	$chargeData = Mage::getModel('report/link')->getLinkedChooserSelected($model->getId());
        	$ccData = Mage::getModel('report/link')->getLinkedChooserSelected($model->getId(),Mage_Report_Model_Link::LINK_TYPE_CC);
        	$chargeArr = array();
        	$ccArr = array();
        	foreach ($chargeData as $item) {
        		array_push($chargeArr,$item['id']);
        	}
        	$data['report_charge'] = implode(',',$chargeArr);
        	$data['report_charge_old'] = implode(',',$chargeArr);
        	foreach ($ccData as $item) {
        		array_push($ccArr,$item['id']);
        	}
        	$data['report_cc'] = implode(',',$ccArr);
        	$data['report_cc_old'] = implode(',',$ccArr);
        } else {
        	$chargeData = array();
        }
        
        $fieldset->addField('report_charge_old', 'hidden', array(
            'name'      => 'report_charge_old',
            'required'  => false,
        ));
        
        $fieldset->addField('report_charge', 'text', array(
            'name'      => 'report_charge',
            'label'     => '报告对象',
            'title'     => '报告对象',
			'class'     => 'input-user',
            'required'  => true,
            'after_element_html' => '<div class="input-user-wrap"><div class="inner" id="report_charge_tag"></div><a href="javascript:;" onclick="openTreechooser(this);" data-tag="report_charge_tag" data-target="report_charge" data-old=\''.json_encode($chargeData).'\' class="add-user"><i class="fa fa-plus f-right"></i></a></div>',
        ));
        $fieldset->addField('report_cc_old', 'hidden', array(
            'name'      => 'report_cc_old',
            'required'  => false,
        ));
        $fieldset->addField('report_cc', 'text', array(
            'name'      => 'report_cc',
            'label'     => '抄送对象',
            'title'     => '抄送对象',
            'class'     => 'input-user',
            'required'  => false,
            'after_element_html' => '<div class="input-user-wrap"><div class="inner" id="report_cc_tag"></div><a href="javascript:;" onclick="openTreechooser(this);" data-tag="report_cc_tag" data-target="report_cc" data-old=\''.json_encode($ccData).'\' class="add-user"><i class="fa fa-plus f-right"></i></a></div>',
        ));
        
        $fieldset->addField('report_desc', 'editor', array(
            'name'      => 'report_desc',
            'label'     => '任务正文',
            'title'     => '任务正文',
            'required'  => true,
            'style' => 'height:200px;width:480px;',
        ));
        
        //上传附件
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

<?php
class Mage_Supplier_Block_Adminhtml_Supplier_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
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
        	"id"=>"edit_form",
        	"action"=>$this->getUrl("*/*/save"),
        	"method"=>"POST",
        ));
        
		$model = Mage::registry("current_supplier");
		$data = $model->getData();
		
        $fieldgroup   = $form->addFieldgroup("base_fieldgroup", array(
            "legend"    => "基本信息",
            "class"    => "",
            "cols" => "8%,17%,8%,17%,8%,17%,8%,17%",
        ));
        $tr = $fieldgroup->addField("tr_base", array(
            "class"    => "",
        ));
        if ($model->getId()) {
			$tr->addField("id", "hidden", array(
	            "name"      => "id",
	        ));
		}
        $tr->addField("supplier_code", "text", array(
            "name"      => "supplier_code",
            "label"     => "编码",
            "required"  => true,
        ));
        $tr->addField("supplier_name", "text", array(
            "name"      => "supplier_name",
            "label"     => "供应商名称",
            "required"  => true,
            "colspan" => "3",
        ));
        $tr->addField("supplier_charge", "text", array(
            "name"      => "supplier_charge",
            "label"     => "负责人",
            "required"  => true,
        ));
		$tr2 = $fieldgroup->addField("tr_base_2", array(
            "class"    => "",
        ));
        $tr2->addField("supplier_phone", "text", array(
            "name"      => "supplier_phone",
            "label"     => "电话",
            "required"  => false,
        ));
        $tr2->addField("supplier_fax", "text", array(
            "name"      => "supplier_fax",
            "label"     => "传真",
            "required"  => false,
        ));
        $tr2->addField("supplier_email", "text", array(
            "name"      => "supplier_email",
            "label"     => "邮箱",
            "required"  => false,
        ));
        $tr2->addField("supplier_website", "text", array(
            "name"      => "supplier_website",
            "label"     => "网站",
            "required"  => false,
        ));
        
        $tr3 = $fieldgroup->addField("tr_base_3", array(
            "class"    => "",
        ));
        $tr3->addField("supplier_level", "select", array(
            "name"      => "supplier_level",
            "label"     => "供应商等级",
            "required"  => false,
            "options" => array(),
        ));
        $tr3->addField("supplier_source", "select", array(
            "name"      => "supplier_source",
            "label"     => "供应商来源",
            "required"  => false,
            "options" => array(),
        ));
        $tr3->addField("supplier_industry", "select", array(
            "name"      => "supplier_industry",
            "label"     => "行业",
            "required"  => false,
            "options" => array(),
        ));
        $tr3->addField("supplier_status", "select", array(
            "name"      => "supplier_status",
            "label"     => "供应商状态",
            "required"  => false,
            "options" => array(),
        ));
        
        $tr4 = $fieldgroup->addField("tr_base_4", array(
            "class"    => "",
        ));
        $tr4->addField("supplier_legal_person", "text", array(
            "name"      => "supplier_legal_person",
            "label"     => "公司法人",
            "required"  => false,
        ));
        $tr4->addField("supplier_tax_no", "text", array(
            "name"      => "supplier_tax_no",
            "label"     => "税务登记号",
            "required"  => false,
        ));
        $tr4->addField("supplier_property", "select", array(
            "name"      => "supplier_property",
            "label"     => "公司性质",
            "required"  => false,
            "options"	=> array(),
        ));
        $tr4->addField("supplier_staff_scale", "select", array(
            "name"      => "supplier_staff_scale",
            "label"     => "员工人数",
            "required"  => false,
            "options"	=> array(),
        ));
        $tr5 = $fieldgroup->addField("tr_base_5", array(
            "class"    => "",
        ));
        $tr5->addField("supplier_turnover", "text", array(
            "name"      => "supplier_turnover",
            "label"     => "营业额",
            "required"  => false,
        ));
        $fieldgroupAddress   = $form->addFieldgroup("address_fieldgroup", array(
            "legend"    => "地址信息",
            "class"    => "",
            "cols" => "8%,17%,8%,17%,8%,17%,8%,17%",
        ));
        $trAddress = $fieldgroupAddress->addField("tr_address", array(
            "class"    => "",
        ));
        $trAddress->addField("supplier_country", "text", array(
            "name"      => "supplier_country",
            "label"     => "国家",
            "required"  => false,
        ));
        $trAddress->addField("supplier_province", "text", array(
            "name"      => "supplier_province",
            "label"     => "省份/地区",
            "required"  => false,
        ));
        $trAddress->addField("supplier_city", "text", array(
            "name"      => "supplier_city",
            "label"     => "城市",
            "required"  => false,
        ));
        $trAddress->addField("supplier_zip", "text", array(
            "name"      => "supplier_zip",
            "label"     => "邮编",
            "required"  => false,
        ));
        $trAddress2 = $fieldgroupAddress->addField("tr_address_2", array(
            "class"    => "",
        ));
        $trAddress2->addField("supplier_address", "textarea", array(
            "name"      => "supplier_address",
            "label"     => "详细地址",
            "required"  => false,
            "colspan" => "7",
        ));
        
        
        $fieldgroupDetail   = $form->addFieldgroup("detail_fieldgroup", array(
            "legend"    => "详细信息",
            "class"    => "",
            "cols" => "8%,17%,8%,17%,8%,17%,8%,17%",
        ));
        $trDetail = $fieldgroupDetail->addField("tr_detail", array(
            "class"    => "",
        ));
        
        $trDetail->addField("supplier_desc", "textarea", array(
            "name"      => "supplier_desc",
            "label"     => "描述",
            "required"  => false,
            "colspan" => "7",
        ));
        
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}


<?php
class Mage_Product_Block_Adminhtml_Product_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
        
		$model = Mage::registry("current_product");
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
        $tr->addField("product_sku", "text", array(
            "name"      => "product_sku",
            "label"     => "产品SKU",
            "required"  => true,
        ));
        $tr->addField("product_factory_no", "text", array(
            "name"      => "product_factory_no",
            "label"     => "工厂货号",
            "required"  => false,
        ));
        $tr->addField("product_category", "text", array(
            "name"      => "product_category",
            "label"     => "产品类别",
            "required"  => true,
            "colspan" => 3,
        ));

		$tr2 = $fieldgroup->addField("tr_base_2", array(
            "class"    => "",
        ));
        $tr2->addField("name_cn", "text", array(
            "name"      => "name_cn",
            "label"     => "中文名称",
            "required"  => true,
            "colspan" => '3',
        ));
        $tr2->addField("name_en", "text", array(
            "name"      => "name_en",
            "label"     => "英文名称",
            "required"  => true,
            "colspan" => '3',
        ));
        
        $tr3 = $fieldgroup->addField("tr_base_3", array(
            "class"    => "",
        ));
        $tr3->addField("tax_rate", "text", array(
            "name"      => "tax_rate",
            "label"     => "退税率",
            "required"  => false,
        ));
        $tr3->addField("product_unit", "select", array(
            "name"      => "product_unit",
            "label"     => "计量单位",
            "required"  => false,
            'options' => array(),
        ));
        $tr3->addField("product_url", "text", array(
            "name"      => "product_url",
            "label"     => "网址",
            "required"  => false,
        ));
        $tr3->addField("product_status", "select", array(
            "name"      => "product_status",
            "label"     => "状态",
            "required"  => false,
            'options' => array(),
        ));
        
        $tr4 = $fieldgroup->addField("tr_base_4", array(
            "class"    => "",
        ));
        $tr4->addField("spec_cn", "textarea", array(
            "name"      => "spec_cn",
            "label"     => "中文规格",
            "required"  => false,
        ));
        $tr4->addField("spec_en", "textarea", array(
            "name"      => "spec_en",
            "label"     => "英文规格",
            "required"  => false,
        ));
        $tr4->addField("model_cn", "textarea", array(
            "name"      => "model_cn",
            "label"     => "中文型号",
            "required"  => false,
        ));
        $tr4->addField("model_en", "textarea", array(
            "name"      => "model_en",
            "label"     => "英文型号",
            "required"  => false,
        ));
        $tr5 = $fieldgroup->addField("tr_base_5", array(
            "class"    => "",
        ));

        $fieldgroupCustom   = $form->addFieldgroup("custom_fieldgroup", array(
            "legend"    => "自定义属性信息",
            "class"    => "",
            "cols" => "8%,17%,8%,17%,8%,17%,8%,17%",
        ));
        $trCustom = $fieldgroupCustom->addField("tr_custom", array(
            "class"    => "",
        ));
        $trCustom->addField("custom_1", "text", array(
            "name"      => "custom_1",
            "label"     => "属性1",
            "required"  => false,
        ));
        $trCustom->addField("custom_2", "text", array(
            "name"      => "custom_2",
            "label"     => "属性2",
            "required"  => false,
        ));
        $trCustom->addField("custom_3", "text", array(
            "name"      => "custom_3",
            "label"     => "属性3",
            "required"  => false,
        ));
        $trCustom->addField("custom_4", "text", array(
            "name"      => "custom_4",
            "label"     => "属性4",
            "required"  => false,
        ));
        $trCustom2 = $fieldgroupCustom->addField("tr_custom_2", array(
            "class"    => "",
        ));
        $trCustom2->addField("custom_5", "text", array(
            "name"      => "custom_5",
            "label"     => "属性5",
            "required"  => false,
        ));
        $trCustom2->addField("custom_6", "text", array(
            "name"      => "custom_6",
            "label"     => "属性6",
            "required"  => false,
        ));
        $trCustom2->addField("custom_7", "text", array(
            "name"      => "custom_7",
            "label"     => "属性7",
            "required"  => false,
        ));
        $trCustom2->addField("custom_8", "text", array(
            "name"      => "custom_8",
            "label"     => "属性8",
            "required"  => false,
        ));
        
        
        $fieldgroupPrice   = $form->addFieldgroup("price_fieldgroup", array(
            "legend"    => "价格信息",
            "class"    => "",
            "cols" => "8%,17%,8%,17%,8%,17%,8%,17%",
        ));
        $trPrice = $fieldgroupPrice->addField("tr_price", array(
            "class"    => "",
        ));
        $trPrice->addField("price_unit", "text", array(
            "name"      => "price_unit",
            "label"     => "单价",
            "required"  => false,
        ));
        $trPrice->addField("price_cost", "text", array(
            "name"      => "price_cost",
            "label"     => "成本价",
            "required"  => false,
        ));
        $trPrice->addField("price_msrp", "text", array(
            "name"      => "price_msrp",
            "label"     => "建议成交价",
            "required"  => false,
        ));
        $trPrice->addField("price_purchase", "text", array(
            "name"      => "price_purchase",
            "label"     => "采购价",
            "required"  => false,
        ));
        
        //
        $fieldgroupPackage   = $form->addFieldgroup("package_fieldgroup", array(
            "legend"    => "包装信息",
            "class"    => "",
            "cols" => "8%,17%,8%,17%,8%,17%,8%,17%",
        ));
        $trPackage = $fieldgroupPackage->addField("tr_package", array(
            "class"    => "",
        ));
        $trPackage->addField("weight_unit", "select", array(
            "name"      => "weight_unit",
            "label"     => "重量单位",
            "required"  => false,
            "options" => array(),
        ));
        $trPackage->addField("package_unit", "select", array(
            "name"      => "package_unit",
            "label"     => "包装单位",
            "required"  => false,
            "options" => array(),
        ));
        $trPackage->addField("box_size", "text", array(
            "name"      => "box_size",
            "label"     => "每箱尺寸",
            "required"  => false,
            "options" => array(),
            "colspan" => "3",
        ));
        
        $trPackage2 = $fieldgroupPackage->addField("tr_package_2", array(
            "class"    => "",
        ));
        $trPackage2->addField("unit_volumn", "text", array(
            "name"      => "unit_volumn",
            "label"     => "单个体积",
            "required"  => false,
        ));
        $trPackage2->addField("unit_weight", "text", array(
            "name"      => "unit_weight",
            "label"     => "单个毛重",
            "required"  => false,
        ));
        $trPackage2->addField("unit_weight_net", "text", array(
            "name"      => "unit_weight_net",
            "label"     => "单个净重",
            "required"  => false,
        ));
        
        $trPackage3 = $fieldgroupPackage->addField("tr_package_3", array(
            "class"    => "",
        ));
        $trPackage3->addField("box_total", "text", array(
            "name"      => "box_total",
            "label"     => "每箱数量",
            "required"  => false,
        ));
        $trPackage3->addField("box_weight", "text", array(
            "name"      => "box_weight",
            "label"     => "每箱毛重",
            "required"  => false,
        ));
        $trPackage3->addField("box_weight_net", "text", array(
            "name"      => "box_weight_net",
            "label"     => "每箱净重",
            "required"  => false,
        ));
        $trPackage4 = $fieldgroupPackage->addField("tr_package_4", array(
            "class"    => "",
        ));
        $trPackage4->addField("package_desc", "textarea", array(
            "name"      => "package_desc",
            "label"     => "包装描述",
            "required"  => false,
            "colspan" => 7,
        ));
        
        $fieldgroupDetail   = $form->addFieldgroup("detail_fieldgroup", array(
            "legend"    => "产品详细信息",
            "class"    => "",
            "cols" => "8%,17%,8%,17%,8%,17%,8%,17%",
        ));
        $trDetail = $fieldgroupDetail->addField("tr_detail", array(
            "class"    => "",
        ));
        $trDetail->addField("product_image", "note", array(
            "name"      => "product_image",
            "label"     => "产品图片",
            "required"  => false,
            "colspan" => 7,
        ));
        $trDetail2 = $fieldgroupDetail->addField("tr_detail_2", array(
            "class"    => "",
        ));
        $trDetail2->addField("product_file", "note", array(
            "name"      => "product_file",
            "label"     => "产品附件",
            "required"  => false,
            "colspan" => 7,
        ));
        $trDetail3 = $fieldgroupDetail->addField("tr_detail_3", array(
            "class"    => "",
        ));
        $trDetail3->addField("desc_cn", "textarea", array(
            "name"      => "desc_cn",
            "label"     => "中文描述",
            "required"  => false,
            "colspan" => 3,
        ));
        $trDetail3->addField("desc_en", "textarea", array(
            "name"      => "desc_en",
            "label"     => "英文描述",
            "required"  => false,
            "colspan" => 3,
        ));
        
        
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

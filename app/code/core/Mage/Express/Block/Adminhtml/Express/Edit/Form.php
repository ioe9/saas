<?php
class Mage_Express_Block_Adminhtml_Express_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
        
		$model = Mage::registry("current_express");
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
        $tr->addField("express_code", "text", array(
            "name"      => "express_code",
            "label"     => "快递单号",
            "title"     => "快递单号",
            "required"  => true,
        ));
        $tr->addField("express_carrier", "select", array(
            "name"      => "express_carrier",
            "label"     => "快递公司",
            "title"     => "快递公司",
            "required"  => false,
            "options" => array(),
           
        ));
        $tr->addField("customer_type", "radio", array(
            "name"      => "customer_type",
            "label"     => "客户类型",
            "title"     => "客户类型",
            "required"  => false,
            "values" => array(),
        ));
        $tr->addField("customer_company", "text", array(
            "name"      => "customer_company",
            "label"     => "客户名称",
            "title"     => "客户名称",
            "required"  => false,
        ));
        
        $fieldgroupCustomer   = $form->addFieldgroup("customer_fieldgroup", array(
            "legend"    => "收件人信息",
            "class"    => "",
            "cols" => "8%,17%,8%,17%,8%,17%,8%,17%",
        ));
        $trCustomer = $fieldgroupCustomer->addField("tr_customer", array(
            "class"    => "",
        ));
        $trCustomer->addField("customer_name", "text", array(
            "name"      => "customer_name",
            "label"     => "收件公司",
            "title"     => "收件公司",
            "required"  => false,
        ));
        $trCustomer->addField("customer_contact", "text", array(
            "name"      => "customer_contact",
            "label"     => "收件人",
            "title"     => "收件人",
            "required"  => false,
        ));
        $trCustomer->addField("customer_country", "text", array(
            "name"      => "customer_country",
            "label"     => "目的国家",
            "title"     => "目的国家",
            "required"  => false,
        ));
        $trCustomer->addField("customer_city", "text", array(
            "name"      => "customer_city",
            "label"     => "目的城市",
            "title"     => "目的城市",
            "required"  => false,
        ));
        
        $trCustomer2 = $fieldgroupCustomer->addField("tr_customer2", array(
            "class"    => "",
        ));
        $trCustomer2->addField("customer_address", "text", array(
            "name"      => "customer_address",
            "label"     => "收件地址",
            "title"     => "收件地址",
            "colspan" => "7",
            "required"  => false,
        ));
        $trCustomer3 = $fieldgroupCustomer->addField("tr_customer3", array(
            "class"    => "",
        ));
        $trCustomer3->addField("date_receive", "text", array(
            "name"      => "date_receive",
            "label"     => "收件日期",
            "title"     => "收件日期",
            "required"  => false,
        ));
        
        $trCustomer3->addField("customer_phone", "text", array(
            "name"      => "customer_phone",
            "label"     => "收件人电话",
            "title"     => "收件人电话",
            "required"  => false,
        ));
        
        $trCustomer3->addField("customer_zip", "text", array(
            "name"      => "customer_zip",
            "label"     => "收件人邮编",
            "title"     => "收件人邮编",
            "required"  => false,
        ));
        
        $fieldgroupSend   = $form->addFieldgroup("send_fieldgroup", array(
            "legend"    => "寄件人信息",
            "class"    => "",
            "cols" => "8%,17%,8%,17%,8%,17%,8%,17%",
        ));
        $trSend = $fieldgroupSend->addField("tr_send", array(
            "class"    => "",
        ));
        $trSend->addField("send_name", "text", array(
            "name"      => "send_name",
            "label"     => "寄件人姓名",
            "title"     => "寄件人姓名",
            "required"  => false,
        ));
        $trSend->addField("send_phone", "text", array(
            "name"      => "send_phone",
            "label"     => "寄件人电话",
            "title"     => "寄件人电话",
            "required"  => false,
        ));
        $trSend->addField("send_company", "select", array(
            "name"      => "send_company",
            "label"     => "寄件公司",
            "title"     => "寄件公司",
            "required"  => false,
            "options" => array(),
            "colspan" => "3",
        ));
        $trSend2 = $fieldgroupSend->addField("tr_send_2", array(
            "class"    => "",
        ));
        $trSend2->addField("send_address", "text", array(
            "name"      => "send_address",
            "label"     => "寄件地址",
            "title"     => "寄件地址",
            "required"  => false,
            "options" => array(),
            "colspan" => "7",
        ));
        $fieldgroupExpress   = $form->addFieldgroup("express_fieldgroup", array(
            "legend"    => "快件信息",
            "class"    => "",
            "cols" => "8%,17%,8%,17%,8%,17%,8%,17%",
        ));
        $trExpress = $fieldgroupExpress->addField("tr_express", array(
            "class"    => "",
        ));
        
        $trExpress->addField("express_collect", "text", array(
            "name"      => "express_collect",
            "label"     => "揽件员",
            "title"     => "揽件员",
            "required"  => false,
        ));
        $trExpress->addField("date_send", "text", array(
            "name"      => "date_send",
            "label"     => "寄件日期",
            "title"     => "寄件日期",
            "required"  => false,
        ));
        $trExpress->addField("type_express", "select", array(
            "name"      => "type_express",
            "label"     => "收寄方式",
            "title"     => "收寄方式",
            "required"  => false,
            "options" => array(),
        ));
        $trExpress->addField("type_pay", "select", array(
            "name"      => "type_pay",
            "label"     => "付费方式",
            "title"     => "付费方式",
            "required"  => false,
            "options" => array(),
        ));
        $trExpress2 = $fieldgroupExpress->addField("tr_express_2", array(
            "class"    => "",
        ));
        $trExpress2->addField("express_volumn", "text", array(
            "name"      => "express_volumn",
            "label"     => "体积(cm³)",
            "title"     => "体积(cm³)",
            "required"  => false,
        ));
        $trExpress2->addField("express_weight", "text", array(
            "name"      => "express_weight",
            "label"     => "重量(kg)",
            "title"     => "重量(kg)",
            "required"  => false,
            
        ));
        $trExpress2->addField("type_fee", "select", array(
            "name"      => "type_fee",
            "label"     => "计费方式",
            "title"     => "计费方式",
            "required"  => false,
            "options" => array(),
        ));
        $trExpress2->addField("express_salesman", "select", array(
            "name"      => "express_salesman",
            "label"     => "业务员",
            "title"     => "业务员",
            "required"  => false,
            "options" => array(),
        ));
        /***
         * 产品信息 TODO...
         */
        $fieldgroupProduct   = $form->addFieldgroup("product_fieldgroup", array(
            "legend"    => "产品信息",
            "class"    => "",
            //"cols" => "8%,17%,8%,17%,8%,17%,8%,17%",
        ));
        $fieldgroupFinance   = $form->addFieldgroup("finance_fieldgroup", array(
            "legend"    => "财务信息",
            "class"    => "",
            "cols" => "8%,17%,8%,17%,8%,17%,8%,17%",
        ));
        $trFinance = $fieldgroupFinance->addField("tr_finance", array(
            "class"    => "",
        ));
        $trFinance->addField("express_account", "text", array(
            "name"      => "express_account",
            "label"     => "快递公司账号",
            "title"     => "快递公司账号",
            "required"  => false,
        ));
        $trFinance->addField("currency_type", "select", array(
            "name"      => "currency_type",
            "label"     => "币种",
            "required"  => false,
            "options" => array(),
        ));
        $trFinance->addField("currency_rate", "text", array(
            "name"      => "currency_rate",
            "label"     => "汇率",
            "required"  => false,
        ));
        $trFinance->addField("total_product", "text", array(
            "name"      => "total_product",
            "label"     => "产品金额",
            "required"  => false,
        ));
        $trFinance2 = $fieldgroupFinance->addField("tr_finance_2", array(
            "class"    => "",
        ));
        $trFinance2->addField("total_carrier", "text", array(
            "name"      => "total_carrier",
            "label"     => "快递费",
            "required"  => false,
        ));
        $trFinance2->addField("total_support", "text", array(
            "name"      => "total_support",
            "label"     => "保价费",
            "required"  => false,
        ));
        $trFinance2->addField("total_other", "text", array(
            "name"      => "total_other",
            "label"     => "其他费用",
            "required"  => false,
        ));
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

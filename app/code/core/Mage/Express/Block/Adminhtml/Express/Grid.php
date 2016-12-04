<?php
class Mage_Express_Block_Adminhtml_Express_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId("expressGrid");
        $this->setDefaultSort("express_id");
        $this->setDefaultDir("desc");
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("express/express")->getCollection();
        $collection->addFieldToFilter("express_company",Mage::registry("current_company")->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn("express_code", array(
            "header"    => "快递单号",
            "align"     => "center",
            "width"     => "140px",
            "index"     => "express_code",
        ));
        
        $this->addColumn("express_carrier", array(
            "header"    => "快递公司",
            "align"     => "center",
            "width"     => "80px",
            "index"     => "express_carrier",
        ));
        $this->addColumn("customer_contact", array(
            "header"    => "收件人",
            "align"     => "center",
            "width"     => "80px",
            "index"     => "customer_contact",
        ));
        $this->addColumn("customer_name", array(
            "header"    => "客户名称",
            "align"     => "center",
            "width"     => "80px",
            "index"     => "customer_name",
        ));
        
        $this->addColumn("customer_company", array(
            "header"    => "收件公司",
            "align"     => "center",
            "width"     => "80px",
            "index"     => "customer_company",
        ));
        $this->addColumn("customer_phone", array(
            "header"    => "收件人电话",
            "align"     => "center",
            "width"     => "80px",
            "index"     => "customer_phone",
        ));
        $this->addColumn("customer_zip", array(
            "header"    => "收件人邮编",
            "align"     => "center",
            "width"     => "80px",
            "index"     => "customer_zip",
        ));
        $this->addColumn("customer_country", array(
            "header"    => "目的国家",
            "align"     => "center",
            "width"     => "80px",
            "index"     => "customer_country",
        ));
        $this->addColumn("customer_city", array(
            "header"    => "目的城市",
            "align"     => "center",
            "width"     => "80px",
            "index"     => "customer_city",
        ));
        $this->addColumn("customer_address", array(
            "header"    => "收件地址",
            "align"     => "center",
            "width"     => "80px",
            "index"     => "customer_address",
        ));
        $this->addColumn("date_receive", array(
            "header"    => "收件日期",
            "align"     => "center",
            "width"     => "80px",
            "index"     => "date_receive",
        ));
        $this->addColumn("date_send", array(
            "header"    => "寄件日期",
            "align"     => "center",
            "width"     => "80px",
            "index"     => "date_send",
        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return;
    }

}


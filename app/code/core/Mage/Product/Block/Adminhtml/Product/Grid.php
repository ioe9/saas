<?php
class Mage_Product_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId("productGrid");
        $this->setDefaultSort("product_id");
        $this->setDefaultDir("desc");
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("product/product")->getCollection();
        $collection->addFieldToFilter("product_company",Mage::registry("current_company")->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn("product_code", array(
            "header"    => "编号",
            "align"     => "center",
            "width"     => "140px",
            "index"     => "product_code",
        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return;
    }

}


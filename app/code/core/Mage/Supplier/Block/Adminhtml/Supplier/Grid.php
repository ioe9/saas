<?php
class Mage_Supplier_Block_Adminhtml_Supplier_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId("supplierGrid");
        $this->setDefaultSort("supplier_id");
        $this->setDefaultDir("desc");
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("supplier/supplier")->getCollection();
        $collection->addFieldToFilter("supplier_company",Mage::registry("current_company")->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn("supplier_code", array(
            "header"    => "编号",
            "align"     => "center",
            "width"     => "140px",
            "index"     => "supplier_code",
        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return;
    }

}


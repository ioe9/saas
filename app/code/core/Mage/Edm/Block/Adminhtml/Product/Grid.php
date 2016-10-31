<?php
class Mage_Edm_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('productGrid');
        $this->setDefaultSort('product_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('edm/product')->getCollection();
        $collection->addFieldToFilter('company_id',Mage::registry('current_company')->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('product_id', array(
            'header'    => "ID",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'product_id',
        ));
		
        $this->addColumn('name', array(
            'header'    => "产品名称",
            'align'     => 'left',
            'index'     => 'name'
        ));
        $this->addColumn('sku', array(
            'header'    => "SKU",
            'align'     => 'left',
            'index'     => 'sku'
        ));
        $this->addColumn('price', array(
            'header'    => "价格",
            'align'     => 'right',
            'index'     => 'price',
        ));
        $this->addColumn('image', array(
            'header'    => "产品主图",
            'align'     => 'center',
            'index'     => 'image',

        ));

        $this->addColumn('date_create', array(
            'header'    => "创建时间",
            'index'     => 'date_create',
        ));
        
        $this->addColumn('action',
            array(
                'header'    => "操作",
                'index'     =>'product_id',
                'sortable' =>false,
                'filter'   => false,
                'no_link' => true,
                'width'	   => '120px',
                'renderer' => 'edm/adminhtml_product_renderer_action'
        ));
        return parent::_prepareColumns();
    }


    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return;
    }

}

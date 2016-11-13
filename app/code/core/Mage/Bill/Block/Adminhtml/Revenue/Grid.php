<?php
class Mage_Bill_Block_Adminhtml_Revenue_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('revenueGrid');
        $this->setDefaultSort('revenue_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bill/revenue')->getCollection();
        $collection->addFieldToFilter('revenue_company',Mage::registry('current_company')->getId());
        $collection->addFieldToFilter('revenue_create',Mage::registry('current_user')->getId());
      	
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('revenue_code', array(
            'header'    => "单号",
            'align'     => 'center',
            'width'     => '140px',
            'index'     => 'revenue_code',
        ));
		
       
      
		 $this->addColumn('revenue_create', array(
            'header'    => "申请人",
            'align'     => 'center',
            'width'     => '70px',
            'index'     => 'name',
            'filter'    => false,
        ));
		$this->addColumn('revenue_department', array(
            'header'    => "部门",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'revenue_department',
            
        ));   
	    
        $this->addColumn('date_create', array(
            'header'    => "申请时间",
            'align'     => 'center',
            'width'     => '140px',
            'index'     => 'date_create',
            'filter'    => false,
        ));
        $this->addColumn('revenue_type', array(
            'header'    => "营收类型",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'revenue_type',
            'type'      => 'options',
            'options'   => Mage::getSingleton('bill/revenue')->getTypeOptions(),
        ));   
        
        $this->addColumn('total_bill', array(
            'header'    => "营收金额",
            'align'     => 'right',
            'width'     => '80px',
            'index'     => 'total_bill',
            'filter'    => false,
        ));
        $this->addColumn('revenue_status', array(
            'header'    => "单据状态",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'revenue_status',
            'type'      => 'options',
            'options'   => Mage::getSingleton('bill/revenue')->getStatusOptions(),
        )); 
        //当前审批
        $this->addColumn('rem_create', array(
            'header'    => "当前审批",
            'align'     => 'right',
            'width'     => '120px',
            'index'     => 'rem_create',
            'filter'    => false,
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

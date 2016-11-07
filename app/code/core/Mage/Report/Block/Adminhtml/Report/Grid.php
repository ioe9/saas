<?php
class Mage_Report_Block_Adminhtml_Report_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('reportGrid');
        $this->setDefaultSort('report_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('report/report')->getCollection();
        $collection->addFieldToFilter('report_company',Mage::registry('current_company')->getId());
      	$filter = Mage::registry('current_filter');
      	
    	if ($filter=='submitto'){
    		//
    		$collection->getSelect()
	    		->joinLeft(
	    			array('u'=>'saas_admin_user'),
					'main_table.report_create=u.user_id',
					array('name')
				);
    		
    	} else if ($filter=='ccto') {
    		
    	} else if ($filter=='submit') {
    		
    	}
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('report_name', array(
            'header'    => "报告标题",
            'align'     => 'left',
            'width'     => '400px',
            'index'     => 'report_name',
        ));
		
        $this->addColumn('report_type', array(
            'header'    => "报告类型",
            'align'     => 'center',
            'width'     => '80px',
            'index'     => 'report_type',
            'type'      => 'options',
            'options'   => Mage::getSingleton('report/type')->getAsOptionsArray(),
        ));
        $filter = Mage::registry('current_filter');
    	if ($filter=='submitto' || $filter=='ccto'){
    		 $this->addColumn('name', array(
	            'header'    => "报告人",
	            'align'     => 'center',
	            'width'     => '100px',
	            'index'     => 'name',
	        ));
    		
    	} else if ($filter=='submit') {
    		
    	}
	       
        /*
        $this->addColumn('report_create', array(
            'header'    => "正文",
            'align'     => 'left',
            'width'     => '500px',
            'index'     => 'report_desc',
        ));*/
        $this->addColumn('date_create', array(
            'header'    => "报告时间",
            'align'     => 'center',
            'width'     => '140px',
            'index'     => 'date_create',
            'filter'    => false,
        ));
        $this->addColumn('action', array(
            'header'    =>  "操作",
            'filter'	=>	false,
            'sortable'	=>	false,
            'align'     => 'center',
            'no_link'   => true,
            'width'		=> '160px',
            'renderer'	=>	'report/adminhtml_report_renderer_action'
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

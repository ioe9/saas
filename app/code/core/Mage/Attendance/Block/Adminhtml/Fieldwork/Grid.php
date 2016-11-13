<?php
class Mage_Attendance_Block_Adminhtml_Fieldwork_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('fieldworkGrid');
        $this->setDefaultSort('fieldwork_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('attendance/fieldwork')->getCollection();
        $collection->addFieldToFilter('fieldwork_company',Mage::registry('current_company')->getId());
      	
    	
		$collection->getSelect()
    		->joinLeft(
    			array('u'=>'saas_admin_user'),
				'main_table.fieldwork_create=u.user_id',
				array('name')
			);
    		
    	
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
       
		$this->addColumn('name', array(
            'header'    => "申请人",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'name',
        ));
    		
    	
         $this->addColumn('date_from', array(
            'header'    => "开始",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'date_from',
            'filter'    => false,
        ));
        $this->addColumn('date_to', array(
            'header'    => "结束",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'date_to',
            'filter'    => false,
        ));
       
        $this->addColumn('fieldwork_hour', array(
            'header'    => "时长",
            'align'     => 'center',
            'width'     => '60px',
            'index'     => 'fieldwork_hour',
            'filter'    => false,
        ));
        
        $this->addColumn('date_create', array(
            'header'    => "申请时间",
            'align'     => 'center',
            'width'     => '120px',
            'index'     => 'date_create',
            'filter'    => false,
        ));
        
        $this->addColumn('fieldwork_status', array(
            'header'    => "状态",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'fieldwork_status',
            'type'      => 'options',
            'options'   => Mage::getModel('attendance/fieldwork')->getStatusOptions(),
        ));
      
        $this->addColumn('action', array(
            'header'    =>  "操作",
            'filter'	=>	false,
            'sortable'	=>	false,
            'align'     => 'center',
            'no_link'   => true,
            'width'		=> '160px',
            'renderer'	=>	'attendance/adminhtml_fieldwork_renderer_action'
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

<?php
class Mage_Attendance_Block_Adminhtml_Leave_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('leaveGrid');
        $this->setDefaultSort('leave_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('attendance/leave')->getCollection();
        $collection->addFieldToFilter('leave_company',Mage::registry('current_company')->getId());
      	
    	
		$collection->getSelect()
    		->joinLeft(
    			array('u'=>'saas_admin_user'),
				'main_table.leave_create=u.user_id',
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
       
        $this->addColumn('leave_hour', array(
            'header'    => "时长",
            'align'     => 'center',
            'width'     => '60px',
            'index'     => 'leave_hour',
            'filter'    => false,
        ));
        
        $this->addColumn('date_create', array(
            'header'    => "申请时间",
            'align'     => 'center',
            'width'     => '120px',
            'index'     => 'date_create',
            'filter'    => false,
        ));
        
        $this->addColumn('leave_status', array(
            'header'    => "状态",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'leave_status',
            'type'      => 'options',
            'options'   => Mage::getModel('attendance/leave')->getStatusOptions(),
        ));
      
        $this->addColumn('action', array(
            'header'    =>  "操作",
            'filter'	=>	false,
            'sortable'	=>	false,
            'align'     => 'center',
            'no_link'   => true,
            'width'		=> '160px',
            'renderer'	=>	'attendance/adminhtml_leave_renderer_action'
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

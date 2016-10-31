<?php
class Mage_Task_Block_Adminhtml_Task_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('taskGrid');
        $this->setDefaultSort('task_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('task/task')->getCollection();
        $collection->addFieldToFilter('task_company',Mage::registry('current_company')->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('task_code', array(
            'header'    => "任务编号",
            'align'     => 'center',
            'width'     => '120px',
            'index'     => 'task_code',
        ));
		
        $this->addColumn('task_name', array(
            'header'    => "任务名称",
            'align'     => 'left',
            'width'     => '220px',
            'index'     => 'task_name',
            'renderer'  => 'task/adminhtml_task_renderer_name',
        ));
        $this->addColumn('task_project', array(
            'header'    => "项目名称",
            'align'     => 'center',
            'width'     => '220px',
            'index'     => 'task_project',
            
        ));
        $filter = Mage::registry('current_filter');
        if ($filter=='charge' || $filter=='focus') {
        	$this->addColumn('task_create', array(
	            'header'    => "发布人",
	            'align'     => 'center',
	            'index'     => 'task_create',
	        ));
        } else if ($filter=='publish') {
        	$this->addColumn('task_charge', array(
	            'header'    => "负责人",
	            'align'     => 'center',
	            'index'     => 'task_charge',
	        ));
        }
	        
        $this->addColumn('task_level', array(
            'header'    => "优先级",
            'align'     => 'center',
            'index'     => 'task_level',
            'type'      => 'options',
            'width'     => '70px',
            'options'   => Mage::getSingleton('task/task')->getLevelOptions(),

        ));
        
        $this->addColumn('task_status', array(
            'header'    => "优先级",
            'align'     => 'center',
            'index'     => 'task_status',
            'type'      => 'options',
            'width'     => '70px',
            'options'   => Mage::getSingleton('task/task')->getStatusOptions(),

        ));
		
		$this->addColumn('date_update', array(
            'header'    => "更新时间",
            'index'     => 'date_update',
            'width'     => '120px',
        ));
        
        $this->addColumn('date_create', array(
            'header'    => "发布时间",
            'index'     => 'date_create',
            'width'     => '120px',
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

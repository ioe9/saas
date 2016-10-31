<?php
class Mage_Task_Block_Adminhtml_Project_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('projectGrid');
        $this->setDefaultSort('project_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('task/project')->getCollection();
        $collection->addFieldToFilter('project_company',Mage::registry('current_company')->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('project_name', array(
            'header'    => "项目名称",
            'align'     => 'left',
            'width'     => '320px',
            'index'     => 'project_name',
            'renderer'  => 'task/adminhtml_project_renderer_name',
            'sortable'  => false,
        ));
		$this->addColumn('date_create', array(
            'header'    => "创建时间",
            'index'     => 'date_create',
            'width'     => '150px',
            'sortable'  => false,
        ));
       
    	$this->addColumn('project_create', array(
            'header'    => "创建人",
            'align'     => 'center',
            'index'     => 'project_create',
            'sortable'  => false,
            'width'     => '70px'
        ));
        
	        
        $this->addColumn('is_private', array(
            'header'    => "项目性质",
            'align'     => 'center',
            'index'     => 'is_private',
            'type'      => 'options',
            'width'     => '70px',
            'options'   => Mage::getSingleton('task/project')->getPrivateOptions(),
            'filter'    => false,
            'sortable'  => false,

        ));
        $this->addColumn('count_task', array(
            'header'    => "总项目",
            'align'     => 'center',
            'width'     => '70px',
            'index'     => 'project_id',
            'renderer'  => 'task/adminhtml_project_renderer_count_task',
            'filter'    => false,
            'sortable'  => false,
        ));
        $this->addColumn('count_process', array(
            'header'    => "处理中",
            'align'     => 'center',
            'width'     => '70px',
            'index'     => 'project_id',
            'renderer'  => 'task/adminhtml_project_renderer_count_process',
            'filter'    => false,
            'sortable'  => false,
        ));
        $this->addColumn('count_audit', array(
            'header'    => "验收中",
            'align'     => 'center',
            'width'     => '70px',
            'index'     => 'project_id',
            'renderer'  => 'task/adminhtml_project_renderer_count_audit',
            'filter'    => false,
            'sortable'  => false,
        ));
        $this->addColumn('count_finish', array(
            'header'    => "已结束",
            'align'     => 'center',
            'width'     => '70px',
            'index'     => 'project_id',
            'renderer'  => 'task/adminhtml_project_renderer_count_finish',
            'filter'    => false,
            'sortable'  => false,
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

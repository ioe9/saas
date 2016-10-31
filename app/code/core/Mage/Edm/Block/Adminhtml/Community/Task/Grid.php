<?php
class Mage_Edm_Block_Adminhtml_Community_Task_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $collection = Mage::getModel('edm/task')->getCollection();
        $collection->addFieldToFilter('task_parent',0);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('task_id', array(
            'header'    => "ID",
            'align'     => 'center',
            'width'     => '65px',
            'index'     => 'task_id',
        ));
        $this->addColumn('task_type', array(
            'header'    => "任务类型",
            'align'     => 'center',
            'width'     => '75px',
            'index'     => 'task_type',
            'type'      => 'options',
            'options'   => array(),
        ));
        $this->addColumn('task_title', array(
            'header'    => "标题",
            'align'     => 'left',
            'index'     => 'task_title',
            'width'     => '200px',
            'sortable' => false,
        ));
        $this->addColumn('task_progress', array(
            'header'    => "任务进度",
            'align'     => 'left',
            'index'     => 'task_progress',
            'width'     => '150px',
            'sortable' => false,
            'filter' => false,
            'renderer' => 'edm/adminhtml_community_task_renderer_progress'
        ));
        $this->addColumn('task_sdesc', array(
            'header'    => "简介",
            'align'     => 'left',
            'index'     => 'task_sdesc',
            'filter' => false,
			'sortable' => false,
        ));
        $this->addColumn('task_difficulty', array(
            'header'    => "难易度",
            'align'     => 'center',
            'index'     => 'task_difficulty',
            'width'     => '75px',
        ));
        $this->addColumn('task_point', array(
            'header'    => "奖励积分",
            'align'     => 'right',
            'index'     => 'task_point',
            'width'     => '75px',
        ));
        $this->addColumn('date_finish', array(
            'header'    => "完成时间",
            'index'     => 'date_finish',
            'width'     => '120px',
            'filter' => false,
            'sortable' => false,
            'renderer' => 'edm/adminhtml_renderer_date'
        ));
        $this->addColumn('date_create', array(
            'header'    => "录入时间",
            'index'     => 'date_create',
            'width'     => '120px',
            'filter' => false,
            'renderer' => 'edm/adminhtml_renderer_date'
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

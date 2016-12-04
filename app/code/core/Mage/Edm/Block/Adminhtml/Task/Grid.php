<?php
class Mage_Edm_Block_Adminhtml_Task_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        if (Mage::registry('current_filter')=='my') {
        	$collection->addFieldToFilter('user_owner',Mage::registry('current_user')->getId());
        } else {
        	$collection->addFieldToFilter('task_parent',array('eq'=>'0'));
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('task_id', array(
            'header'    => "编号",
            'align'     => 'center',
            'width'     => '65px',
            'index'     => 'task_id',
        ));
        $this->addColumn('task_type', array(
            'header'    => "任务类型",
            'align'     => 'center',
            'width'     => '120px',
            'index'     => 'task_type',
            'type'      => 'options',
            'options'   => Mage::getSingleton('edm/task')->getTypeOptions(),
        ));
        $this->addColumn('task_title', array(
            'header'    => "标题",
            'align'     => 'center',
            'index'     => 'task_title',
            'width'     => '250px',
            'sortable' => false,
        ));
        $this->addColumn('task_progress_claim', array(
            'header'    => "认领进度",
            'align'     => 'left',
            'index'     => 'task_progress',
            'width'     => '100px',
            'sortable' => false,
            'filter' => false,
            'renderer' => 'edm/adminhtml_task_renderer_progress_claim'
        ));
        $this->addColumn('task_progress_collect', array(
            'header'    => "采集进度",
            'align'     => 'left',
            'index'     => 'task_progress',
            'width'     => '100px',
            'sortable' => false,
            'filter' => false,
            'renderer' => 'edm/adminhtml_task_renderer_progress_collect'
        ));
        /*
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
        ));*/
        $this->addColumn('task_point', array(
            'header'    => "奖励积分",
            'align'     => 'center',
            'index'     => 'task_point',
            'width'     => '75px',
        ));
        $this->addColumn('date_finish', array(
            'header'    => "预计完成时间",
            'index'     => 'date_finish',
            'width'     => '100px',
            'filter' => false,
            'sortable' => false,
            'align'     => 'center',
            'renderer' => 'edm/adminhtml_renderer_date'
        ));
        $this->addColumn('date_create', array(
            'header'    => "录入时间",
            'index'     => 'date_create',
            'width'     => '100px',
            'filter' => false,
            'align'     => 'center',
            'renderer' => 'edm/adminhtml_renderer_date'
        ));
		$this->addColumn('action',
            array(
                'header'    => "操作",
                'index'     =>'task_id',
                'sortable' =>false,
                'filter'   => false,
                'no_link' => true,
                'align'     => 'center',
                'width'	   => '100px',
                'renderer' => 'edm/adminhtml_task_renderer_action'
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

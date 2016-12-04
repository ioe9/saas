<?php
class Mage_Edm_Block_Adminhtml_Feedback_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('feedbackGrid');
        $this->setDefaultSort('feedback_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('edm/feedback')->getCollection();
        
        if (Mage::registry('current_filter')=='my') {
        	$collection->addFieldToFilter('feedback_company',Mage::registry('current_company')->getId());
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
		
        $this->addColumn('feedback_title', array(
            'header'    => "标题",
            'align'     => 'center',
            'index'     => 'feedback_title'
        ));

        $this->addColumn('date_create', array(
            'header'    => "提交时间",
            'index'     => 'date_create',
            'align'     => 'center',
            'width'		=> '150px',
            'renderer' => 'adminhtml/widget_grid_renderer_datetime',
            'filter' => false,
        ));
        
        $this->addColumn('action',
            array(
                'header'    => "操作",
                'index'     =>'feedback_id',
                'sortable' =>false,
                'filter'   => false,
                'no_link' => true,
                'width'	   => '120px',
                'renderer' => 'edm/adminhtml_feedback_renderer_action'
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

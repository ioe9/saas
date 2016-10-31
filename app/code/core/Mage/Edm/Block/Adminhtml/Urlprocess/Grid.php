<?php
class Mage_Edm_Block_Adminhtml_Urlprocess_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('urlprocessGrid');
        $this->setDefaultSort('urlprocess_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('edm/urlprocess')->getCollection();
        $collection->addFieldToFilter('company_id',Mage::registry('current_company')->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('url_id', array(
            'header'    => "ID",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'url_id',
        ));
		
        $this->addColumn('url', array(
            'header'    => "网址",
            'align'     => 'left',
            'index'     => 'url'
        ));
        $this->addColumn('position', array(
            'header'    => "优先度",
            'align'     => 'right',
            'index'     => 'position',
            'width'		=> '60px',
        ));
        /*
        $this->addColumn('is_active', array(
            'header'    => "提交状态",
            'align'     => 'center',
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array('0'=>'未提交','1'=>'已提交')
        ));*/

		$this->addColumn('status', array(
            'header'    => "处理状态",
            'align'     => 'center',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array('0'=>'未处理','1'=>'处理中','2'=>'处理完成','-1'=>'无效URL')
        ));
        
        $this->addColumn('date_create', array(
            'header'    => "录入时间",
            'index'     => 'date_create',
            'width'		=> '120px',
        ));
        $this->addColumn('action', array(
            'header'    =>  "操作",
            'filter'	=>	false,
            'sortable'	=>	false,
            'no_link'   => true,
            'width'		=> '160px',
            'renderer'	=>	'edm/adminhtml_urlprocess_renderer_action'
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

<?php
class Mage_Edm_Block_Adminhtml_Setting_Advantage_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('groupGrid');
        $this->setDefaultSort('group_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('edm/company_advantage_group')->getCollection();
        $collection->addFieldToFilter('group_company',Mage::registry('current_company')->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
		
        $this->addColumn('group_name', array(
            'header'    => "分组名称",
            'align'     => 'center',
            'index'     => 'group_name',
            'width'		=> '200px',
        ));
        $this->addColumn('sdesc', array(
            'header'    => "备注",
            'align'     => 'left',
            'index'     => 'sdesc',
            'width'		=> '200px',
        ));
        $this->addColumn('group_position', array(
            'header'    => "排序",
            'align'     => 'center',
            'index'     => 'group_position',
            'width'		=> '80px',
        ));
        $this->addColumn('date_create', array(
            'header'    => "创建时间",
            'index'     => 'date_create',
            'width'		=> '140px',
        ));
        
        $this->addColumn('action',
            array(
                'header'    => "操作",
                'index'     =>'group_id',
                'sortable' =>false,
                'filter'   => false,
                'no_link' => true,
                'width'	   => '120px',
                'renderer' => 'edm/adminhtml_setting_advantage_renderer_action'
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

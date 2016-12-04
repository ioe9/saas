<?php
class Mage_Edm_Block_Adminhtml_Client_Group_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $collection = Mage::getModel('edm/company_client_group')->getCollection();
        $collection->addFieldToFilter('group_company',Mage::registry('current_company')->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('group_name', array(
            'header'    => "名称",
            'align'     => 'center',
            'width'     => '200px',
            'index'     => 'group_name',
            //'filter'    => false,
        ));
		$this->addColumn('count_client', array(
            'header'    => "客户总数",
            'align'     => 'center',
            'width'     => '80px',
            'index'     => 'count_client',
            'filter'    => false,
        ));
        $this->addColumn('group_memo', array(
            'header'    => "备注",
            'align'     => 'center',
            'width'     => '300px',
            'index'     => 'group_memo',
            'filter'    => false,
        ));
        
        $this->addColumn('date_create', array(
            'header'    => "创建时间",
            'align'     => 'center',
            'width'     => '120px',
            'index'     => 'date_create',
            'renderer' => 'edm/adminhtml_renderer_date',
            'filter'    => false,
        ));
        $this->addColumn('action', array(
            'header'    =>  "操作",
            'filter'	=>	false,
            'sortable'	=>	false,
            'no_link'   => true,
            'width'		=> '180px',
            'align'     => 'center',
            'renderer'	=>	'edm/adminhtml_client_group_renderer_action'
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

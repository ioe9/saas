<?php
class Mage_Edm_Block_Adminhtml_Template_My_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('templateGrid');
        $this->setDefaultSort('template_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('edm/company_template_collection');
        $collection->addFieldToFilter('template_company',Mage::registry('current_company')->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('template_id', array(
            'header'    => "ID",
            'align'     => 'center',
            'width'     => '65px',
            'index'     => 'template_id',
        ));
		
        $this->addColumn('template_name', array(
            'header'    => "名称",
            'align'     => 'center',
            'index'     => 'template_name',
			'sortable' => false,
        ));
       
        
        $this->addColumn('memo', array(
            'header'    => "备注",
            'align'     => 'left',
            'index'     => 'memo',
            'filter' => false,
			'sortable' => false,
			'width'     => '300px',
        ));
       $this->addColumn('template_user', array(
            'header'    => "创建人",
            'align'     => 'center',
            'index'     => 'template_user',
            'width'     => '120px',
            'sortable' => false,
            'default' => '系统',
        ));
        $this->addColumn('date_create', array(
            'header'    => "创建时间",
            'index'     => 'date_create',
            'filter' => false,
            'width'     => '120px',
        ));
        
        $this->addColumn('action',
            array(
                'header'    => "操作",
                'index'     =>'template_id',
                'sortable' =>false,
                'filter'   => false,
                'no_link' => true,
                'width'	   => '120px',
                'renderer' => 'edm/adminhtml_template_my_renderer_action'
        ));
        return parent::_prepareColumns();
    }


    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl2($row)
    {
        return;
    }

}

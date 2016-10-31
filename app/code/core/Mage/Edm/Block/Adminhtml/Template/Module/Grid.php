<?php
class Mage_Edm_Block_Adminhtml_Template_Module_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('moduleGrid');
        $this->setDefaultSort('module_id');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        //$collection = Mage::getResourceModel('edm/company_template_module_collection');
        //$collection->addFieldToFilter('module_company',Mage::registry('current_company')->getId());
        $collection = Mage::getResourceModel('edm/templates_module_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
		/*
        $this->addColumn('module_id', array(
            'header'    => "ID",
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'module_id',
        ));*/
		
        $this->addColumn('name', array(
            'header'    => "模块名称",
            'align'     => 'center',
            'index'     => 'name'
        ));
        $this->addColumn('memo', array(
            'header'    => "备注",
            'align'     => 'center',
            'filterable'  => false,
            'index'     => 'memo'
        ));
        /*
        $this->addColumn('date_create', array(
            'header'    => "创建时间",
            'index'     => 'date_create',
        ));*/
        $this->addColumn('action',
            array(
                'header'    =>  "系统自带",
                'width'     => '120px',
                'type'      => 'action',
                'align'     => 'center',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => "管理",
                        'url'       => array('base'=> '*/*/configsys'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true,
        ));
        $this->addColumn('actioncopy',
            array(
                'header'    =>  "自定义",
                'width'     => '120px',
                'type'      => 'action',
                'align'     => 'center',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => "管理",
                        'url'       => array('base'=> '*/*/config'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true,
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

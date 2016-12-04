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
        $collection->getSelect()
	    		->joinLeft(
	    			array('u'=>'saas_admin_user'),
					'main_table.template_create=u.user_id',
					array('name as username')
				);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('template_id', array(
            'header'    => "ID",
            'align'     => 'center',
            'width'     => '80px',
            'index'     => 'template_id',
        ));
		
        $this->addColumn('template_name', array(
            'header'    => "名称",
            'align'     => 'center',
            'index'     => 'template_name',
			'sortable' => false,
        ));
       $this->addColumn('template_scene', array(
            'header'    => "场景",
            'align'     => 'center',
            'width'     => '120px',
            'index'     => 'template_scene',
			'sortable' => false,
			'type' => 'options',
			'options' => Mage::getSingleton('edm/template_scene')->getAsOptions(),
        ));

       $this->addColumn('username', array(
            'header'    => "创建人",
            'align'     => 'center',
            'index'     => 'username',
            'width'     => '120px',
            'sortable' => false,
            //'default' => '系统',
        ));
        $this->addColumn('template_status', array(
            'header'    => "状态",
            'align'     => 'center',
            'index'     => 'template_status',
			'sortable' => false,
			'type' => 'options',
			'options' => Mage::getSingleton('edm/company_template')->getStatusOptions(),
        ));
        $this->addColumn('date_create', array(
            'header'    => "创建时间",
            'index'     => 'date_create',
            'filter' => false,
            'align'     => 'center',
            'width'     => '150px',
            'renderer' => 'adminhtml/widget_grid_renderer_datetime'
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
